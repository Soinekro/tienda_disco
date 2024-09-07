<?php

namespace App\Traits\Livewire;

use Livewire\Attributes\Url;

trait PaginateTrait
{
    //propiedades generales
    #[Url]
    public $search = '';
    #[Url]
    public $sort = 'id';
    #[Url]
    public $direction = 'desc';
    #[Url]
    public $perPage = '10';

    public $action = 'create';
    public $active = true;
    //carga de datos
    public $readyToLoad = false;

    public function order($sort)
    {
        if ($this->sort === $sort) {
            if ($this->direction === 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function loadItems()
    {
        $this->readyToLoad = true;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function updatingDirection()
    {
        $this->resetPage();
    }
}
