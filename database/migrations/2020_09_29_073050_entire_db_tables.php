<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

    use Symfony\Component\Console\Output\ConsoleOutput;

    class EntireDbTables extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            $consoleOutput = new ConsoleOutput();
            DB::statement("
        SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET time_zone = \"+00:00\";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


        ");
            $consoleOutput->writeln("Creating table: chars");
            DB::statement("
CREATE TABLE `chars` (
  `CHAR_ID` bigint(20) NOT NULL,
  `NAME` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `REFRESH_TOKEN` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Eve OAuth2 Refresh Token'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: content_creators");
            DB::statement("
CREATE TABLE `content_creators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `NAME` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CHAR_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `DISCORD` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `YOUTUBE` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TWITTER` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: delete_cleanup");
            DB::statement("
CREATE TABLE `delete_cleanup` (
  `ITEM_ID` bigint(20) UNSIGNED NOT NULL,
  `TIER` enum('1','2','3','4','5','6','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `TYPE` enum('Electrical','Dark','Exotic','Firestorm','Gamma') COLLATE utf8mb4_unicode_ci NOT NULL,
  `DELETES_SUM` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: detailed_loot");
            DB::statement("
CREATE TABLE `detailed_loot` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `ITEM_ID` bigint(20) UNSIGNED NOT NULL,
  `RUN_ID` int(10) UNSIGNED NOT NULL,
  `COUNT` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: donors");
            DB::statement("
CREATE TABLE `donors` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `CHAR_ID` bigint(20) UNSIGNED NOT NULL,
  `NAME` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AMOUNT` bigint(20) UNSIGNED NOT NULL,
  `DATE` datetime NOT NULL,
  `REASON` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: drone_bandwidth");
            DB::statement("
CREATE TABLE `drone_bandwidth` (
  `ID` bigint(20) UNSIGNED NOT NULL COMMENT 'ITEM ID of a ship or drone',
  `VALUE` int(11) NOT NULL COMMENT 'Max drone bandwidth for ships, used drone bandwidth for drones'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: droprates_cache");
            DB::statement("
CREATE TABLE `droprates_cache` (
  `ITEM_ID` bigint(20) UNSIGNED NOT NULL,
  `TIER` enum('1','2','3','4','5','6','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `TYPE` enum('Electrical','Dark','Exotic','Firestorm','Gamma','All') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Electrical',
  `DROPPED_COUNT` int(10) UNSIGNED NOT NULL,
  `RUNS_COUNT` int(10) UNSIGNED NOT NULL,
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: droprates_cache_bckp");
            DB::statement("
CREATE TABLE `droprates_cache_bckp` (
  `ITEM_ID` bigint(20) UNSIGNED NOT NULL,
  `TIER` enum('1','2','3','4','5') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `TYPE` enum('Electrical','Dark','Exotic','Firestorm','Gamma','All') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Electrical',
  `DROPPED_COUNT` int(10) UNSIGNED NOT NULL,
  `RUNS_COUNT` int(10) UNSIGNED NOT NULL,
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        ");
            $consoleOutput->writeln("Creating table: droprates_increment");
            DB::statement("
CREATE TABLE `droprates_increment` (
  `ITEM_ID` bigint(20) UNSIGNED NOT NULL,
  `TIER` enum('1','2','3','4','5','6','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `TYPE` enum('Electrical','Dark','Exotic','Firestorm','Gamma','All') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Electrical',
  `DROPPED_COUNT` int(10) UNSIGNED NOT NULL,
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: filament_types");
            DB::statement("
CREATE TABLE `filament_types` (
  `TIER` enum('1','2','3','4','5','6','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `TYPE` enum('Electrical','Dark','Exotic','Firestorm','Gamma') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ITEM_ID` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: fits");
            DB::statement("
CREATE TABLE `fits` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `CHAR_ID` bigint(20) NOT NULL COMMENT 'Fit owner',
  `SHIP_ID` bigint(20) UNSIGNED NOT NULL,
  `NAME` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DESCRIPTION` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `STATS` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `STATUS` enum('QUEUED','DONE','FAULT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `PRICE` bigint(20) UNSIGNED NOT NULL,
  `RAW_EFT` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `SUBMITTED` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `VIDEO_LINK` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PRIVACY` enum('public','incognito','private') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FFH` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: fit_recommendations");
            DB::statement("
CREATE TABLE `fit_recommendations` (
  `FIT_ID` bigint(20) UNSIGNED NOT NULL,
  `ELECTRICAL` smallint(5) UNSIGNED NOT NULL,
  `DARK` smallint(5) UNSIGNED NOT NULL,
  `EXOTIC` smallint(5) UNSIGNED NOT NULL,
  `FIRESTORM` smallint(5) UNSIGNED NOT NULL,
  `GAMMA` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: fit_tags");
            DB::statement("
CREATE TABLE `fit_tags` (
  `FIT_ID` bigint(20) UNSIGNED NOT NULL,
  `TAG_NAME` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TAG_VALUE` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: forevercache");
            DB::statement("
CREATE TABLE `forevercache` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: hash_links");
            DB::statement("
CREATE TABLE `hash_links` (
  `ID` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `VALUE` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: invTypes20200511");
            DB::statement("
CREATE TABLE `invTypes20200511` (
  `typeID` int(11) NOT NULL,
  `groupID` int(11) DEFAULT NULL,
  `typeName` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `mass` double DEFAULT NULL,
  `volume` double DEFAULT NULL,
  `capacity` double DEFAULT NULL,
  `portionSize` int(11) DEFAULT NULL,
  `raceID` int(11) DEFAULT NULL,
  `basePrice` decimal(19,4) DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `marketGroupID` int(11) DEFAULT NULL,
  `iconID` int(11) DEFAULT NULL,
  `soundID` int(11) DEFAULT NULL,
  `graphicID` int(11) DEFAULT NULL
) ;

        ");
            $consoleOutput->writeln("Creating table: item_prices");
            DB::statement("
CREATE TABLE `item_prices` (
  `ITEM_ID` bigint(20) UNSIGNED NOT NULL,
  `PRICE_BUY` bigint(20) UNSIGNED NOT NULL,
  `PRICE_SELL` bigint(20) UNSIGNED NOT NULL,
  `PRICE_LAST_UPDATED` timestamp NOT NULL DEFAULT current_timestamp(),
  `DESCRIPTION` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `GROUP_ID` bigint(20) UNSIGNED NOT NULL,
  `GROUP_NAME` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NAME` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: item_slot");
            DB::statement("
CREATE TABLE `item_slot` (
  `ITEM_ID` bigint(20) UNSIGNED NOT NULL,
  `ITEM_SLOT` enum('high','mid','low','rig','drone','ammo','cargo','booster','implant') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: lost_items");
            DB::statement("
CREATE TABLE `lost_items` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `ITEM_ID` bigint(20) UNSIGNED NOT NULL,
  `RUN_ID` int(10) UNSIGNED NOT NULL,
  `COUNT` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");

            $consoleOutput->writeln("Creating table: parsed_fit_items");
            DB::statement("
CREATE TABLE `parsed_fit_items` (
  `FIT_ID` bigint(20) UNSIGNED NOT NULL,
  `ITEM_ID` bigint(20) UNSIGNED NOT NULL,
  `COUNT` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `AMMO_ID` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: patreon_donor_displays");
            DB::statement("
CREATE TABLE `patreon_donor_displays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monthly_donation` double(8,2) NOT NULL,
  `joined` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: preferences");
            DB::statement("
CREATE TABLE `preferences` (
  `CHAR_ID` bigint(20) NOT NULL,
  `SETTING` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `VALUE_BOOLEAN` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: previous_dumps_tables");
            DB::statement("
CREATE TABLE `previous_dumps_tables` (
  `TABLE_NAME` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ORDER_ASC` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            DB::statement("
INSERT INTO `previous_dumps_tables` (`TABLE_NAME`, `ORDER_ASC`) VALUES
('invTypes20200511', 1);

        ");
            $consoleOutput->writeln("Creating table: privacy");
            DB::statement("
CREATE TABLE `privacy` (
  `CHAR_ID` bigint(20) NOT NULL,
  `PANEL` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DISPLAY` enum('private','public') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: runs");
            DB::statement("
CREATE TABLE `runs` (
  `ID` int(10) UNSIGNED NOT NULL,
  `CHAR_ID` bigint(20) NOT NULL,
  `PUBLIC` tinyint(1) NOT NULL,
  `TIER` enum('1','2','3','4','5','6','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `TYPE` enum('Electrical','Dark','Exotic','Firestorm','Gamma') COLLATE utf8mb4_unicode_ci NOT NULL,
  `LOOT_ISK` int(11) NOT NULL,
  `SURVIVED` tinyint(1) NOT NULL DEFAULT 1,
  `RUN_DATE` date NOT NULL,
  `SHIP_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `DEATH_REASON` enum('TIMEOUT','TANK_FAILED','CONNECTION_DROP','PILOTING_MISTAKE','PVP_DEATH','OVERHEAT_FAILURE','EXPERIMENTAL_FIT','OTHER') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PVP_CONDUIT_USED` tinyint(1) DEFAULT NULL,
  `PVP_CONDUIT_SPAWN` tinyint(1) DEFAULT NULL,
  `FILAMENT_PRICE` int(10) UNSIGNED DEFAULT NULL,
  `LOOT_TYPE` enum('BIOADAPTIVE_ONLY','BIOADAPTIVE_PLUS_SOME_CANS','BIOADAPTIVE_PLUS_MOST_CANS','BIOADAPTIVE_PLUS_ALL_CANS') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KILLMAIL` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CREATED_AT` timestamp NULL DEFAULT current_timestamp(),
  `RUNTIME_SECONDS` int(10) UNSIGNED DEFAULT NULL,
  `FIT_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `IS_BONUS` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: run_report");
            DB::statement("
CREATE TABLE `run_report` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `REPORTER_CHAR_ID` bigint(20) NOT NULL,
  `RUN_ID` int(10) UNSIGNED NOT NULL,
  `MESSAGE` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PROCESSED` tinyint(1) NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: ship_lookup");
            DB::statement("
CREATE TABLE `ship_lookup` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `NAME` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GROUP` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IS_CRUISER` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: stopwatch");
            DB::statement("
CREATE TABLE `stopwatch` (
  `CHAR_ID` bigint(20) NOT NULL,
  `ENTERED_ABYSS` datetime DEFAULT NULL,
  `EXITED_ABYSS` datetime DEFAULT NULL,
  `IN_ABYSS` tinyint(1) NOT NULL,
  `EXPIRE` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: tutorial_votes");
            DB::statement("
CREATE TABLE `tutorial_votes` (
  `video_id` bigint(20) UNSIGNED NOT NULL,
  `char_id` bigint(20) NOT NULL,
  `opinion` enum('approves','disapproves') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: users");
            DB::statement("
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: video_tutorials");
            DB::statement("
CREATE TABLE `video_tutorials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `youtube_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_creator_id` bigint(20) UNSIGNED NOT NULL,
  `video_bookmarks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tier` enum('1','2','3','4','5','6','0') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Electrical','Dark','Exotic','Firestorm','Gamma') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
            $consoleOutput->writeln("Creating table: video_tutorial_fits");
            DB::statement("
CREATE TABLE `video_tutorial_fits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `video_tutorial_id` bigint(20) UNSIGNED NOT NULL,
  `fit_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");

            DB::statement("
            CREATE TABLE `tier` (
            `TIER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");


            $consoleOutput->writeln("Creating table: type");
            DB::statement("
CREATE TABLE `type` (
            `TYPE` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

            $consoleOutput->writeln("Adding indices: chars");
            DB::statement("
ALTER TABLE `chars`
  ADD PRIMARY KEY (`CHAR_ID`);

        ");
            $consoleOutput->writeln("Adding indices: content_creators");
            DB::statement("
ALTER TABLE `content_creators`
  ADD PRIMARY KEY (`id`);

        ");
            $consoleOutput->writeln("Adding indices: delete_cleanup");
            DB::statement("
ALTER TABLE `delete_cleanup`
  ADD KEY `delete_cleanup_item_id_tier_type_index` (`ITEM_ID`,`TIER`,`TYPE`);

        ");
            $consoleOutput->writeln("Adding indices: detailed_loot");
            DB::statement("
ALTER TABLE `detailed_loot`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `detailed_loot_RUN_ID_index` (`RUN_ID`),
  ADD KEY `dl_item_id_foreign` (`ITEM_ID`);

        ");
            $consoleOutput->writeln("Adding indices: donors");
            DB::statement("
ALTER TABLE `donors`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `donors_date_index` (`DATE`);

        ");
            $consoleOutput->writeln("Adding indices: drone_bandwidth");
            DB::statement("
ALTER TABLE `drone_bandwidth`
  ADD PRIMARY KEY (`ID`);

        ");
            $consoleOutput->writeln("Adding indices: droprates_cache");
            DB::statement("
ALTER TABLE `droprates_cache`
  ADD PRIMARY KEY (`ITEM_ID`,`TIER`,`TYPE`);

        ");
            $consoleOutput->writeln("Adding indices: droprates_increment");
            DB::statement("
ALTER TABLE `droprates_increment`
  ADD PRIMARY KEY (`ITEM_ID`,`TIER`,`TYPE`,`UPDATED_AT`),
  ADD KEY `droprates_increment_item_id_updated_at_tier_type_index` (`ITEM_ID`,`UPDATED_AT`,`TIER`,`TYPE`);

        ");
            $consoleOutput->writeln("Adding indices: filament_types");
            DB::statement("
ALTER TABLE `filament_types`
  ADD PRIMARY KEY (`TIER`,`TYPE`);

        ");
            $consoleOutput->writeln("Adding indices: fits");
            DB::statement("
ALTER TABLE `fits`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fits_ship_id_index` (`SHIP_ID`),
  ADD KEY `fits_price_index` (`PRICE`),
  ADD KEY `fits_char_id_foreign` (`CHAR_ID`),
  ADD KEY `fits_ffh_index` (`FFH`);

        ");
            $consoleOutput->writeln("Adding indices: fit_recommendations");
            DB::statement("
ALTER TABLE `fit_recommendations`
  ADD KEY `fit_recommendations_fit_id_foreign` (`FIT_ID`);

        ");
            $consoleOutput->writeln("Adding indices: fit_tags");
            DB::statement("
ALTER TABLE `fit_tags`
  ADD PRIMARY KEY (`FIT_ID`,`TAG_NAME`);

        ");
            $consoleOutput->writeln("Adding indices: forevercache");
            DB::statement("
ALTER TABLE `forevercache`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `forevercache_name_index` (`Name`(191));

        ");
            $consoleOutput->writeln("Adding indices: hash_links");
            DB::statement("
ALTER TABLE `hash_links`
  ADD PRIMARY KEY (`ID`);

        ");
            $consoleOutput->writeln("Adding indices: invTypes20200511");
            DB::statement("
ALTER TABLE `invTypes20200511`
  ADD PRIMARY KEY (`typeID`),
  ADD KEY `ix_invTypes_groupID` (`groupID`);

        ");
            $consoleOutput->writeln("Adding indices: item_prices");
            DB::statement("
ALTER TABLE `item_prices`
  ADD PRIMARY KEY (`ITEM_ID`),
  ADD KEY `item_prices_price_last_updated_index` (`PRICE_LAST_UPDATED`);

        ");
            $consoleOutput->writeln("Adding indices: item_slot");
            DB::statement("
ALTER TABLE `item_slot`
  ADD KEY `item_slot_item_id_foreign` (`ITEM_ID`);

        ");
            $consoleOutput->writeln("Adding indices: lost_items");
            DB::statement("
ALTER TABLE `lost_items`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `li_item_id_foreign` (`ITEM_ID`),
  ADD KEY `li_run_id_foreign` (`RUN_ID`);

        ");

            $consoleOutput->writeln("Adding indices: parsed_fit_items");
            DB::statement("
ALTER TABLE `parsed_fit_items`
  ADD KEY `parsed_fit_items_fit_id_index` (`FIT_ID`);

        ");
            $consoleOutput->writeln("Adding indices: patreon_donor_displays");
            DB::statement("
ALTER TABLE `patreon_donor_displays`
  ADD PRIMARY KEY (`id`);

        ");
            $consoleOutput->writeln("Adding indices: preferences");
            DB::statement("
ALTER TABLE `preferences`
  ADD KEY `preferences_char_id_foreign` (`CHAR_ID`);

        ");
            $consoleOutput->writeln("Adding indices: previous_dumps_tables");
            DB::statement("
ALTER TABLE `previous_dumps_tables`
  ADD PRIMARY KEY (`TABLE_NAME`);

        ");
            $consoleOutput->writeln("Adding indices: privacy");
            DB::statement("
ALTER TABLE `privacy`
  ADD KEY `privacy_char_id_foreign` (`CHAR_ID`);

        ");
            $consoleOutput->writeln("Adding indices: runs");
            DB::statement("
ALTER TABLE `runs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `runs_char_id_index` (`CHAR_ID`),
  ADD KEY `runs_run_date_index` (`RUN_DATE`),
  ADD KEY `runs_ship_id_index` (`SHIP_ID`),
  ADD KEY `runs_created_at_index` (`CREATED_AT`),
  ADD KEY `runs_fit_id` (`FIT_ID`);

        ");
            $consoleOutput->writeln("Adding indices: run_report");
            DB::statement("
ALTER TABLE `run_report`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `run_report_run_id_unique` (`RUN_ID`),
  ADD KEY `run_report_created_at_index` (`CREATED_AT`),
  ADD KEY `rr_char_id_foreign` (`REPORTER_CHAR_ID`);

        ");
            $consoleOutput->writeln("Adding indices: ship_lookup");
            DB::statement("
ALTER TABLE `ship_lookup`
  ADD PRIMARY KEY (`ID`);

        ");
            $consoleOutput->writeln("Adding indices: stopwatch");
            DB::statement("
ALTER TABLE `stopwatch`
  ADD PRIMARY KEY (`CHAR_ID`);

        ");
            $consoleOutput->writeln("Adding indices: tutorial_votes");
            DB::statement("
ALTER TABLE `tutorial_votes`
  ADD PRIMARY KEY (`video_id`,`char_id`),
  ADD KEY `tutorial_votes_video_id_index` (`video_id`),
  ADD KEY `tutorial_votes_video_id_opinion_index` (`video_id`,`opinion`),
  ADD KEY `tutorial_votes_char_id_foreign` (`char_id`);

        ");
            $consoleOutput->writeln("Adding indices: users");
            DB::statement("
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

        ");
            $consoleOutput->writeln("Adding indices: video_tutorials");
            DB::statement("
ALTER TABLE `video_tutorials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_tutorials_content_creator_id_foreign` (`content_creator_id`);

        ");
            $consoleOutput->writeln("Adding indices: video_tutorial_fits");
            DB::statement("
ALTER TABLE `video_tutorial_fits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_tutorial_fits_video_tutorial_id_foreign` (`video_tutorial_id`),
  ADD KEY `video_tutorial_fits_fit_id_foreign` (`fit_id`);

        ");
            $consoleOutput->writeln("Setting autoincrement: content_creators");
            DB::statement("
ALTER TABLE `content_creators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

        ");
            $consoleOutput->writeln("Setting autoincrement: detailed_loot");
            DB::statement("
ALTER TABLE `detailed_loot`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

        ");
            $consoleOutput->writeln("Setting autoincrement: fits");
            DB::statement("
ALTER TABLE `fits`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

        ");
            $consoleOutput->writeln("Setting autoincrement: lost_items");
            DB::statement("
ALTER TABLE `lost_items`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

        ");

            $consoleOutput->writeln("Setting autoincrement: patreon_donor_displays");
            DB::statement("
ALTER TABLE `patreon_donor_displays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

        ");
            $consoleOutput->writeln("Setting autoincrement: runs");
            DB::statement("
ALTER TABLE `runs`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

        ");
            $consoleOutput->writeln("Setting autoincrement: run_report");
            DB::statement("
ALTER TABLE `run_report`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

        ");
            $consoleOutput->writeln("Setting autoincrement: users");
            DB::statement("
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

        ");
            $consoleOutput->writeln("Setting autoincrement: video_tutorials");
            DB::statement("
ALTER TABLE `video_tutorials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

        ");
            $consoleOutput->writeln("Setting autoincrement: video_tutorial_fits");
            DB::statement("
ALTER TABLE `video_tutorial_fits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;


        ");
            $consoleOutput->writeln("Adding constraints: delete_cleanup");
            DB::statement("
ALTER TABLE `delete_cleanup`
  ADD CONSTRAINT `delete_cleanup_item_id_foreign` FOREIGN KEY (`ITEM_ID`) REFERENCES `item_prices` (`ITEM_ID`);

        ");
            $consoleOutput->writeln("Adding constraints: detailed_loot");
            DB::statement("
ALTER TABLE `detailed_loot`
  ADD CONSTRAINT `dl_item_id_foreign` FOREIGN KEY (`ITEM_ID`) REFERENCES `item_prices` (`ITEM_ID`),
  ADD CONSTRAINT `dl_run_id_foreign` FOREIGN KEY (`RUN_ID`) REFERENCES `runs` (`ID`);

        ");
            $consoleOutput->writeln("Adding constraints: droprates_cache");
            DB::statement("
ALTER TABLE `droprates_cache`
  ADD CONSTRAINT `drc_item_id_foreign` FOREIGN KEY (`ITEM_ID`) REFERENCES `item_prices` (`ITEM_ID`);

        ");
            $consoleOutput->writeln("Adding constraints: droprates_increment");
            DB::statement("
ALTER TABLE `droprates_increment`
  ADD CONSTRAINT `droprates_increment_item_id_foreign` FOREIGN KEY (`ITEM_ID`) REFERENCES `item_prices` (`ITEM_ID`);

        ");
            $consoleOutput->writeln("Adding constraints: fits");
            DB::statement("
ALTER TABLE `fits`
  ADD CONSTRAINT `fits_char_id_foreign` FOREIGN KEY (`CHAR_ID`) REFERENCES `chars` (`CHAR_ID`),
  ADD CONSTRAINT `fits_ship_id_foreign` FOREIGN KEY (`SHIP_ID`) REFERENCES `ship_lookup` (`ID`);

        ");
            $consoleOutput->writeln("Adding constraints: fit_recommendations");
            DB::statement("
ALTER TABLE `fit_recommendations`
  ADD CONSTRAINT `fit_recommendations_fit_id_foreign` FOREIGN KEY (`FIT_ID`) REFERENCES `fits` (`ID`);

        ");
            $consoleOutput->writeln("Adding constraints: fit_tags");
            DB::statement("
ALTER TABLE `fit_tags`
  ADD CONSTRAINT `fit_tags_fit_id_foreign` FOREIGN KEY (`FIT_ID`) REFERENCES `fits` (`ID`);

        ");
            $consoleOutput->writeln("Adding constraints: item_slot");
            DB::statement("
ALTER TABLE `item_slot`
  ADD CONSTRAINT `item_slot_item_id_foreign` FOREIGN KEY (`ITEM_ID`) REFERENCES `item_prices` (`ITEM_ID`);

        ");
            $consoleOutput->writeln("Adding constraints: lost_items");
            DB::statement("
ALTER TABLE `lost_items`
  ADD CONSTRAINT `li_item_id_foreign` FOREIGN KEY (`ITEM_ID`) REFERENCES `item_prices` (`ITEM_ID`),
  ADD CONSTRAINT `li_run_id_foreign` FOREIGN KEY (`RUN_ID`) REFERENCES `runs` (`ID`);

        ");
            $consoleOutput->writeln("Adding constraints: preferences");
            DB::statement("
ALTER TABLE `preferences`
  ADD CONSTRAINT `preferences_char_id_foreign` FOREIGN KEY (`CHAR_ID`) REFERENCES `chars` (`CHAR_ID`);

        ");
            $consoleOutput->writeln("Adding constraints: privacy");
            DB::statement("
ALTER TABLE `privacy`
  ADD CONSTRAINT `privacy_char_id_foreign` FOREIGN KEY (`CHAR_ID`) REFERENCES `chars` (`CHAR_ID`);

        ");
            $consoleOutput->writeln("Adding constraints: runs");
            DB::statement("
ALTER TABLE `runs`
  ADD CONSTRAINT `runs_char_id_foreign` FOREIGN KEY (`CHAR_ID`) REFERENCES `chars` (`CHAR_ID`),
  ADD CONSTRAINT `runs_ship_id_foreign` FOREIGN KEY (`SHIP_ID`) REFERENCES `ship_lookup` (`ID`);

        ");
            $consoleOutput->writeln("Adding constraints: run_report");
            DB::statement("
ALTER TABLE `run_report`
  ADD CONSTRAINT `rr_char_id_foreign` FOREIGN KEY (`REPORTER_CHAR_ID`) REFERENCES `chars` (`CHAR_ID`);

        ");
            $consoleOutput->writeln("Adding constraints: stopwatch");
            DB::statement("
ALTER TABLE `stopwatch`
  ADD CONSTRAINT `stopwatch_char_id_foreign` FOREIGN KEY (`CHAR_ID`) REFERENCES `chars` (`CHAR_ID`);

        ");
            $consoleOutput->writeln("Adding constraints: tutorial_votes");
            DB::statement("
ALTER TABLE `tutorial_votes`
  ADD CONSTRAINT `tutorial_votes_char_id_foreign` FOREIGN KEY (`char_id`) REFERENCES `chars` (`CHAR_ID`),
  ADD CONSTRAINT `tutorial_votes_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `video_tutorials` (`id`);

        ");
            $consoleOutput->writeln("Adding constraints: video_tutorials");
            DB::statement("
ALTER TABLE `video_tutorials`
  ADD CONSTRAINT `video_tutorials_content_creator_id_foreign` FOREIGN KEY (`content_creator_id`) REFERENCES `content_creators` (`id`);

        ");
            $consoleOutput->writeln("Adding constraints: video_tutorial_fits");
            DB::statement("
ALTER TABLE `video_tutorial_fits`
  ADD CONSTRAINT `video_tutorial_fits_fit_id_foreign` FOREIGN KEY (`fit_id`) REFERENCES `fits` (`ID`),
  ADD CONSTRAINT `video_tutorial_fits_video_tutorial_id_foreign` FOREIGN KEY (`video_tutorial_id`) REFERENCES `video_tutorials` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
");


        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            throw new RuntimeException("Migrating DOWN is unsupported.");
        }
    }
