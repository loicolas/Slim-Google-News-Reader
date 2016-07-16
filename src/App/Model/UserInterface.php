<?php

namespace App\Model;

/**
 *
 * @author Loïc Colas <loicolas@gmail.com>
 */
interface UserInterface
{
    public function getId(): int;
    
    public function getEmail(): string;
    
    public function getUsername(): string;
}
