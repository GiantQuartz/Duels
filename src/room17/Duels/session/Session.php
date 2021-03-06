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

namespace room17\Duels\session;


use pocketmine\level\Location;
use pocketmine\Player;
use room17\Duels\match\Match;

class Session {
    
    /** @var SessionManager */
    private $manager;
    
    /** @var Player */
    private $owner;
    
    /** @var null|Match */
    private $match;
    
    /** @var string[] */
    private $invitations = [];
    
    /** @var null|Session */
    private $lastInvitationOwner = null;
    
    /** @var null|Location */
    private $originalLocation = null;
    
    /**
     * Session constructor.
     * @param SessionManager $manager
     * @param Player $owner
     */
    public function __construct(SessionManager $manager, Player $owner) {
        $this->manager = $manager;
        $this->owner = $owner;
    }
    
    /**
     * @return string
     */
    public function __toString(): string {
        return $this->owner->getName();
    }
    
    /**
     * @return Player
     */
    public function getOwner(): Player {
        return $this->owner;
    }
    
    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->owner->getName();
    }
    
    /**
     * @return bool
     */
    public function hasMatch(): bool {
        return $this->match != null;
    }
    
    /**
     * @return Match
     */
    public function getMatch(): Match {
        return $this->match;
    }
    
    /**
     * @return null|Session
     */
    public function getLastInvitationOwner(): ?Session {
        return $this->lastInvitationOwner;
    }
    
    /**
     * @return null|Location
     */
    public function getOriginalLocation(): ?Location {
        return $this->originalLocation;
    }
    
    /**
     * @param Session $session
     * @return bool
     */
    public function hasInvitationFrom(Session $session): bool {
        return isset($this->invitations[$session->getUsername()]);
    }
    
    /**
     * @param Session $session
     */
    public function addInvitationFrom(Session $session): void {
        $this->invitations[$session->getUsername()] = true;
        $this->lastInvitationOwner = $session;
    }
    
    /**
     * @param Session $session
     */
    public function clearInvitationFrom(Session $session): void {
        if($this->hasInvitationFrom($session)) {
            if($this->lastInvitationOwner === $session) {
                $this->lastInvitationOwner = null;
            }
            unset($this->invitations[$session->getUsername()]);
        } else {
            $this->manager->getLoader()->getLogger()->error("Error trying to remove an invitation from $session");
        }
    }
    
    public function clearAllInvitations(): void {
        $this->invitations = [];
        $this->lastInvitationOwner = null;
    }
    
    /**
     * @param null|Session $owner
     */
    public function setLastInvitationOwner(?Session $owner): void {
        $this->lastInvitationOwner = $owner;
    }
    
    /**
     * @internal
     * @param null|Match $match
     */
    public function setMatch(?Match $match): void {
        $this->match = $match;
    }
    
    /**
     * @internal
     * @param null|Location $originalLocation
     */
    public function setOriginalLocation(?Location $originalLocation): void {
        $this->originalLocation = $originalLocation;
    }
    
    /**
     * @param string $identifier
     * @param array $args
     * @return string
     */
    public function localizeMessage(string $identifier, array $args = []): string {
        return $this->manager->getLoader()->getSettings()->getMessage($identifier, $args);
    }
    
    /**
     * @param string $identifier
     * @param array $args
     */
    public function sendLocalizedMessage(string $identifier, array $args = []): void {
        $this->owner->sendMessage($this->localizeMessage($identifier, $args));
    }
    
    /**
     * @param string $identifier
     * @param array $args
     */
    public function sendLocalizedPopup(string $identifier, array $args = []): void {
        $this->owner->sendPopup($this->localizeMessage($identifier, $args));
    }
    
    /**
     * @param string $identifier
     * @param array $args
     */
    public function sendLocalizedTip(string $identifier, array $args = []): void {
        $this->owner->sendTip($this->localizeMessage($identifier, $args));
    }
    
}