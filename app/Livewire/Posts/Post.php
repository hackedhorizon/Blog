<?php

namespace App\Livewire\Posts;

use Livewire\Component;

class Post extends Component
{
    public bool $myModal1 = false;

    public function updatedMyModal1()
    {
        dd($this->myModal1);
    }

    public function render()
    {
        return view('livewire.posts.post');
    }
}
