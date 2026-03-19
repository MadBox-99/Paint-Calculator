<?php

declare(strict_types=1);

use App\Livewire\CalculateForm;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(CalculateForm::class)
        ->assertStatus(200);
});
