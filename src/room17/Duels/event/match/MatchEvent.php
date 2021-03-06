<?php
/**
 *  _____    ____    ____   __  __  __  ______
 * |  __ \  / __ \  / __ \ |  \/  |/_ ||____  |
 * | |__) || |  | || |  | || \  / | | |    / /
 * |  _  / | |  | || |  | || |\/| | | |   / /
 * | | \ \ | |__| || |__| || |  | | | |  / /
 * |_|  \_\ \____/  \____/ |_|  |_| |_| /_/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 */

declare(strict_types=1);

namespace room17\Duels\event\match;


use room17\Duels\event\DuelsEvent;
use room17\Duels\match\Match;

class MatchEvent extends DuelsEvent {
    
    /** @var Match */
    private $match;
    
    /**
     * MatchEvent constructor.
     * @param Match $match
     */
    public function __construct(Match $match) {
        $this->match = $match;
    }
    
    /**
     * @return Match
     */
    public function getMatch(): Match {
        return $this->match;
    }
    
}