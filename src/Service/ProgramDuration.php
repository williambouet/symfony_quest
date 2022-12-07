<?php

namespace App\Service;

use App\Entity\Program;
use App\Repository\EpisodeRepository;


class ProgramDuration
{

    public const HOUR_IN_A_DAY = 24;
    public function calculate(Program $program): string
    {
        $duration = 0;
        $seasons = $program->getSeasons();
        foreach ($seasons as $season) {
            $episodes = $season->getEpisodes();
            foreach ($episodes as $epidode) {
                $duration += $epidode->getDuration();
            }
        }

        $hour = floor($duration / 60);
        $min = round($duration % 60);

        if ($hour >= self::HOUR_IN_A_DAY) {
            $day = round($hour / self::HOUR_IN_A_DAY);
            $hour = $hour - ($day * self::HOUR_IN_A_DAY);

            return '(' . $duration . 'min)  ' . $day . ' jours ' . $hour . ' heures ' . $min . 'minutes, pour tout voir.';
        }

        return '(' . $duration . 'min)  ' . $hour . ' heures ' . $min . 'minutes, pour tout voir.';
    }
}
