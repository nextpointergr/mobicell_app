<?php

namespace App\Livewire\Admin;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
abstract class AComponent extends Component
{
    public string $routeContext = 'admin';

}

