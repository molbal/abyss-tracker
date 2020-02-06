<?php


    namespace App\Http\Controllers;


    class BarkController {


        /**
         * Gets the death reason. It is a long and chatty text
         * @param $all_data object must have DEATH_REASON property
         * @return string
         */
        public function getDeathReasonBark($all_data): string {
            switch ($all_data->DEATH_REASON) {
                case 'TIMEOUT':
                    $death_reason = "The timer ran out. As the warp field collapsed, the ship's hull crumbled under the pressure from environmental effects and life support quickly failed - for both the ship, and the capsule.";
                    break;
                case 'TANK_FAILED':
                    $death_reason = "The ship's tank could not handle the incoming DPS. The hostile entities in the abyss meticulously tore down the defenses. First the shield system collapsed, continued by the armor plating, and then the hull crumbled at last.";
                    break;
                case 'CONNECTION_DROP':
                    $death_reason = "Connection dropped. The ship's crew just stood there, waiting for commands from the captain. But the captain did not respond and the ship was declared missing in action.";
                    break;
                case 'PILOTING_MISTAKE':
                    $death_reason = "The captain of the ship made a grave piloting mistake. Maybe the ship flew into a cloud, or got too close to a group of fatal enemies. Hopefully the Capsuleer learned from this mistake. ";
                    break;
                case 'PVP_DEATH':
                    $death_reason = "I went into the PVP room and lost. After the pilot neutralized the threat the lurking hostile entities posed, felt confident enough to choose the Proving Conduit, to go face to face, claw to claw against another Conqueror of the Abyss. Unfortunately for us, the other pilot prepared better for this challenge.";
                    break;
                case 'OVERHEAT_FAILURE':
                    $death_reason = "I overheated a critical module too much accidentally. All pilots know that there are times when the ship systems need to perform beyond safety limits. However, this time a module failed while performing over the regular load and caused a failure in ship systems. The partially inoperable ship did not pose much of a threat for the Abyss entities.";
                    break;
                case 'EXPERIMENTAL_FIT':
                    $death_reason = "I tried an experimental fit and it didn't work. An idea, theorycrafing, ship purchase, fitting the modules, preparing for the Abyss journey. These are the necessary steps for testing a new loadout in the Abyss. This time it was not working well. Sacrifices were made. ";
                    break;
                case 'OTHER':
                    $death_reason = "There was something else. The pilot does not remember. It is too complicated. C̶͚̚a̸̼͌p̷̲̀s̴̼͛u̷͕̕ḷ̴̀ę̷̓ ̷̎͜l̴͍͗ḯ̶̳f̶̟͂e̵͔̽ ̷͎̄s̷̞̑ŭ̸͈p̶̪͠p̴̥͆ȯ̴̩r̷͉̀t̶͚̆ ̷̨̃f̵̟͆ä̴̺́i̵͖̒l̴͋͜ë̴͓d̴̖́";
                    break;
                default:
                    $death_reason = "We do not have data from the death reason. Maybe the pilot simply does not remember - or maybe it is classified.";
            }
            return $death_reason;
        }

        /**
         * Gets the loot strategy description from all_data.
         * @param $all_data object must have LOOT_TYPE property
         * @return string
         */
        public function getLootStrategyDescription($all_data): string {
            switch ($all_data->LOOT_TYPE) {
                case 'BIOADAPTIVE_ONLY':
                    $looting = "Looted the bioadaptive caches only";
                    break;
                case 'BIOADAPTIVE_PLUS_SOME_CANS':
                    $looting = "Looted the bioadaptive caches + some cans";
                    break;
                case 'BIOADAPTIVE_PLUS_MOST_CANS':
                    $looting = "Looted the bioadaptive caches + most cans";
                    break;
                case 'BIOADAPTIVE_PLUS_ALL_CANS':
                    $looting = "Looted the bioadaptive caches + all the cans";
                    break;
                default:
                    $looting = "It's unclear if only the cache or the cans were looted too";
                    break;
            }
            return $looting;
        }


        /**
         * Generated code! Ignore the mess.
         * @param $data
         * @param $averageLootForTier
         * @return array
         */
        public function getRunSummaryBark($data, $averageLootForTier): array {
            if ($data->LOOT_ISK > 0) {
                $percent = ($data->LOOT_ISK / $averageLootForTier) * 100;
            }
            else {
                $percent = -100;
            }
            if ($percent == -100) {
                $run_summary = "a catastrophic";
            }
            else {
                if ($percent < 30) {
                    $run_summary = "a destitute";
                }
                else {
                    if ($percent < 50) {
                        $run_summary = "an impecunious";
                    }
                    else {
                        if ($percent < 70) {
                            $run_summary = "an unsatisfactory";
                        }
                        else {
                            if ($percent < 80) {
                                $run_summary = "a slightly below average";
                            }
                            else {
                                if ($percent < 90) {
                                    $run_summary = "an okay-ish";
                                }
                                else {
                                    if ($percent < 110) {
                                        $run_summary = "a decent";
                                    }
                                    else {
                                        if ($percent < 125) {
                                            $run_summary = "a plentiful";
                                        }
                                        else {
                                            if ($percent < 150) {
                                                $run_summary = "an exuberant";
                                            }
                                            else {
                                                if ($percent < 333) {
                                                    $run_summary = "an exceptional";
                                                }
                                                else {
                                                    $run_summary = "a jackpot-hitting";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return [$percent, $run_summary];
        }

    }
