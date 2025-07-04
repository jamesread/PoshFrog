<?php

namespace pfrog;

use libAllure\DatabaseFactory;

class ContentGenerator {
    public function generate() 
    {
        if ($this->getCount('buildings') < 10) {
            $this->createBusiness();
        }

        if ($this->getCount('workers') < 10)
        {
            $this->createWorker();
        }

        if ($this->getCount('buildings') < 10) 
        {
            $this->createBuildings();
        }
    }

    private function createFromCSV($csv, $type, $min, $max): void
    {
        $list = explode(",", $csv);

        $randomKey = array_rand($list);
        $randomName = trim($list[$randomKey]);

        $sql = 'INSERT INTO inventory_' . $type . ' (name, cost_gold) VALUES (:name, :gold)';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->execute([
            'name' => $randomName,
            'gold' => round(rand($min, $max), 10),
        ]);
    }

    private function createWorker(): void
    {
        $workers = "";
        $workers .= "Aiden, Lily, Xavier, Willow, Caleb, Ruby, Oliver, Daisy, Ethan, Penelope, Mason, Hazel, Lucas, Poppy, Jackson, Luna, Harper, Finn, Olive, Leo, Meadow, Henry, Clover, Max, Aurora, Noah, Ivy, Liam, Savannah, Emma, Felix, Juniper, Ava, Milo, Stella, Benjamin, Violet, Samuel, Luna, Oscar, Wren, Charlie, Clementine, Arthur, Daisy";
        $workers .= "Isaac, Autumn, Gabriel, Summer, Elijah, Skyler, Sophia, Jasper, Scarlett, Asher, Aurora, Ezra, Willow, Levi, Hazel, Caleb, Ruby, Julian, Luna, Felix, Ivy, Atticus, Daisy, Hudson, Meadow, Wyatt, Clover, Liam, Poppy, Theo, Olive, Elijah, Violet, Jackson, Hazel, Logan, Luna, Mason, Ruby, Owen, Lily, Lucas, Stella, Samuel, Daisy, Dylan, Willow, Benjamin, Rose";

        $this->createFromCSV($workers, 'workers', 50, 400); 
    }

    private function createBusiness(): void
    {
        $buildingses = "";
        $buildingses .= "TechWizards, GreenLeaf Cafe, StellarPrints, GourmetGurus, PetPals Resort, ByteBuddies IT, PawsitiveVibes, FashionFrenzy, BrewsNGlues, PixelPursuit, BlissfulBites Bakery, EcoVibe Ventures, DreamScape Travel, TinkerTech Toys, ChillZone Spa, JoyRide Adventures, SnackAttack Deli, ZenZone Yoga, The Laughing Llama Pub, InfiniteGaming, WhiskerWonder Pet Supplies, EcoEats Market, FunkyFusion Studio, JazzyJukebox Music Shop, SerenitySpace Spa,";
        $buildingses .= "ElectroBloom, UrbanHarvest, CraftyCritters, MoonlightCinema, FlavorFiesta, WanderlustWares, BuzzyBeats Cafe, Playtopia Arcade, ZenithZest Gym, WhimsyWonders, SipNSavor Winery, TechTonic Solutions, FreshFinds Market, GroovyGizmos, PawfectStay Inn, SweetTooth Emporium, StellarStitches Tailors, CloudNine Skydiving, The GreenThumb Nursery, BitsNBites Food Truck, HappyTails Pet Spa, SplashDown Watersports, GadgetGallery, TranquilTrails Hiking Tours, SparkleSpot Jewelry";

        $this->createFromCSV($buildingses, 'businessess', 250, 1500);
    }

    private function createBuildings(): void
    {
        $buildings = "";
        $buildings .= "Warehouse, Store";

        $this->createFromCSV($buildings, 'buildings', 250, 1500);
    }

    private function getCount(string $type) 
    {
        $sql = 'SELECT count(id) AS count FROM inventory_' . $type . '';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->execute();

        $res = $stmt->fetchRowNotNull();
        $res = $res['count'];

        return $res;
    }
}
