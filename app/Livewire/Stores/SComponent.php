<?php
namespace App\Livewire\Stores;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
abstract class SComponent extends Component
{
    public string $routeContext = 'web';

}

