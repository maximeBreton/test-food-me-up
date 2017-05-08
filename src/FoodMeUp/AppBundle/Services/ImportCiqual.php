<?php

namespace FoodMeUp\AppBundle\Services;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Monolog\Logger;
use Doctrine\ORM\EntityManager;
use FoodMeUp\Entity\FoodGroup;
use FoodMeUp\Entity\Food;
use FoodMeUp\Entity\Component;
use FoodMeUp\Entity\CompiledData;

/**
 *
 * @author breton
 *
 */
class ImportCiqual
{
    private $entityManager;

    private $logger;

    private $eventDispatcher;

    private $path;

    private $allFoodGroupId;

    private $allFoodId;

    private $data = [];

    private $component = [];

    private $componentObject = [];

    private $allFoodGroupInsert = [];

    private $allFoodGroupInsertObject = [];

    private $allFoodInsert = [];

    private $allComponentCOrigcpnmabrInsert = [];

    private $extRequired = array('csv');

    /**
     *
     * @param EntityManager $entityManager
     * @param Logger $logger
     */
    public function __construct(EntityManager $entityManager, Logger $logger, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->eventDispatcher = $eventDispatcher;

        $this->allFoodGroupId = $this->entityManager->getRepository('FoodMeUp\Entity\FoodGroup')->getAllFoodGroupId();
        $this->allFoodId = $this->entityManager->getRepository('FoodMeUp\Entity\Food')->getAllFoodId();
    }

    public function initData($path)
    {
        $this->path = $path;
        if (!$this->checkFile()) {
            return false;
        }
        $this->data = $this->unserializeAndFormat();
        return true;
    }

    /**
     *
     * @param unknown $path
     */
    public function run()
    {
        if (count($this->data) === 0) {
            return false;
        }

        $this->entityManager->getConnection()->beginTransaction();
        try {

            // insert component
            $this->component = array_slice(
                array_keys($this->data[0]), 4
            );
            $this->insertComponent($this->component);

            $batchSize = 50;
            foreach ($this->data as $key => $value) {
                $food = null;
                $foodGroup = $this->insertFoodGroup($value);

                if ($foodGroup instanceof FoodGroup) {
                    $food = $this->insertFood($value, $foodGroup);
                } else {
                    $this->logger->addAlert('Erreur lors de l\'import n°' . $key . '');
                }

                if ($food instanceof Food) {
                    $this->insertCompiledData($value, $food);
                }

                if (($key % $batchSize) === 0) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                }

                $this->eventDispatcher->dispatch(
                    'import.ciqual.progress.bar'
                );
            }

            $this->entityManager->flush();
            $this->entityManager->clear();

            $this->entityManager->getConnection()->commit();

        } catch (\Exception $e) {

            $this->logger->error('Erreur lors de l\'import des données <<'. $e->getMessage() .' - ' . $e->getFile() . ' - ' . $e->getLine() . '>>');
            $this->entityManager->getConnection()->rollback();
            throw $e;
        }

        return true;
    }

    /**
     *
     * @return unknown
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     *
     * @param unknown $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }


    /**
     *
     * @return Array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     *
     * @param array $data
     */
    public function setData(Array $data)
    {
        $this->data = $data;
    }

    /**
     *
     * @throws \Exception
     * @return boolean
     */
    private function checkFile()
    {
        if (!file_exists($this->path)) {
            throw new \Exception('This file doesn\'t exist !');
        }

        $info = new \SplFileInfo($this->path);
        $extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);

        if (!in_array($extension, $this->extRequired)) {
            $this->logger->error('Le format du fichier est invalide !');
            return false;
        }

        return true;
    }

    /**
     *
     * @return Array
     */
    private function unserializeAndFormat()
    {

        $serializer = new Serializer(
            [new ObjectNormalizer()],
            [new CsvEncoder(';', '"', '\\', '\n')]
        );
        $data = $serializer->decode(
            utf8_encode(file_get_contents($this->path)), 'csv'
        );

        return $data;
    }

    /**
     *
     * @param array $data
     * @return boolean
     */
    private function insertFoodGroup(Array $data)
    {
        $dateNow = new \DateTime('now');
        $foodGroup = null;

        if (trim($data['ORIGGPCD']) === '') {
            $this->logger->error('Le champ ORIGGPCD est obligatoire pour l\enregistrement dans la table "foodGroup"');
            return false;
        }

        // check l'existance d'un élément food en base -created
        if (!in_array(trim($data['ORIGGPCD']), $this->allFoodGroupId, true)
        && !in_array(trim($data['ORIGGPCD']), $this->allFoodGroupInsert, true)) {

            $this->logger->info('INSERT foodGroup Item - ORIGGPCD['.trim($data['ORIGGPCD']).']');
            $foodGroup = new FoodGroup();
            $foodGroup->setOriggpcd(trim($data['ORIGGPCD']));
            $foodGroup->setOriggpfr(trim($data['ORIGGPFR']));
            $foodGroup->setCreatedDate($dateNow);
            $foodGroup->setUpdatedDate($dateNow);
            $this->entityManager->persist($foodGroup);
            $this->allFoodGroupInsert[] = trim($data['ORIGGPCD']);
            $this->allFoodGroupInsertObject[trim($data['ORIGGPCD'])] = $foodGroup;

        // updated
        } else if (in_array(trim($data['ORIGGPCD']), $this->allFoodGroupInsert, true)) {

            $this->logger->info('UPDATE foodGroup Item - ORIGGPCD['.$data['ORIGGPCD'].']');

            // dans le cas ou le foodGroup existe mais n'a pas encore été flushé en base
            if (!key_exists(trim($data['ORIGGPCD']), $this->allFoodGroupInsertObject)) {
                $foodGroup = $this->entityManager->getRepository('FoodMeUp\Entity\FoodGroup')->findOneByOriggpcd(
                    trim($data['ORIGGPCD'])
                );
                $foodGroup->setOriggpfr(trim($data['ORIGGPFR']));
                $foodGroup->setUpdatedDate($dateNow);
                $this->entityManager->merge($foodGroup);
            } else {
                $foodGroup = $this->allFoodGroupInsertObject[trim($data['ORIGGPCD'])];
            }
        }

        return $foodGroup;
    }

    /**
     *
     * @param array $data
     * @param FoodGroup $foodGroup
     * @return boolean|\FoodMeUp\Entity\Food
     */
    private function insertFood(Array $data, FoodGroup $foodGroup)
    {
        $dateNow = new \DateTime('now');
        if (trim($data['ORIGFDCD']) === '') {
            $this->logger->error('Le champ ORIGFDCD est obligatoire pour l\enregistrement dans la table "food"');
            return false;
        }

        if (!in_array(trim($data['ORIGFDCD']), $this->allFoodId, true) && !in_array(trim($data['ORIGFDCD']), $this->allFoodInsert, true)) {
            $this->logger->info('INSERT food Item - ORIGGPCD[' . $data['ORIGFDCD'] . ']');
            $food = new Food();
            $food->setOrigfdcd(trim($data['ORIGFDCD']));
            $food->setOrigfdnm(trim($data['ORIGFDNM']));
            $food->setFoodGroup($foodGroup);
            $food->setCreatedDate($dateNow);
            $food->setUpdatedDate($dateNow);
            $this->entityManager->detach($food);
            $this->entityManager->merge($food);
            $this->allFoodInsert[] = trim($data['ORIGFDCD']);

        // updated
        } else if (!in_array($data['ORIGFDCD'], $this->allFoodInsert, true)) {
            $food = $this->entityManager->getRepository('FoodMeUp\Entity\Food')->findOneByOrigfdcd(
                trim($data['ORIGFDCD'])
            );
            $food->setOrigfdnm(trim($data['ORIGFDNM']));
            $food->setUpdatedDate($dateNow);
            $this->entityManager->merge($food);
        }

        return $food;
    }

    /**
     *
     * @param array $headersCsv
     * @return boolean
     */
    private function insertComponent(Array $headersCsv)
    {
        $dateNow = new \DateTime('now');

        foreach ($headersCsv as $item) {

            // on check l'existance en base de donnée pour eviter une reinsertion
            $component = $this->entityManager->getRepository('FoodMeUp\Entity\Component')->findOneByCOrigcpnmabr($item);
            if (trim($item) != '' && $component === null) {
                $this->logger->info('INSERT Component Item - [' . trim($item) . ']');
                $component = new Component();
                $component->setCOrigcpnmabr(trim($item));
                $component->setCreatedDate($dateNow);
                $component->setUpdatedDate($dateNow);

                $this->entityManager->persist($component);
                $this->allComponentCOrigcpnmabrInsert[] = trim($item);
                $this->componentObject[trim($item)] = $component;

            } else if ($component instanceof Component) {
                $this->componentObject[trim($item)] = $component;
                $this->logger->info('Le component <<' . trim($item) . '>> existe en base');
            } else {
                $this->logger->alert('Erreur insertion component <<Colonne vide>>');
            }
        }

        $this->entityManager->flush();
        $this->entityManager->clear();
        return true;
    }

    /**
     *
     * @param array $data
     * @param Food $food
     */
    private function insertCompiledData(Array $data, Food $food)
    {
        foreach ($this->component as $item) {

            // on check que la colonne composition est bien defini dans le csv
            if (array_key_exists($item, $data) && trim($data[$item]) !== '') {

                // on enregistre dans compiledData
                $compiledData = new CompiledData();
                $compiledData->setComponent($this->componentObject[$item]);
                $compiledData->setFood($food);
                $compiledData->setSelvalTexte(trim($data[$item]));

                $this->entityManager->merge($compiledData);
            } else {
                $this->logger->alert(
                    'Erreur insertion CompiledData, valeur vide ['. $data[$item] . '][' . $food->getOrigfdnm() . ']'
                );
            }
        }
    }
}
