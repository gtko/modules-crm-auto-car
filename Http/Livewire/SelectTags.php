<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;

class SelectTags extends Component
{
    public $tags;
    public $tagSelect;
    public $tagsDossier;
    public $dossier;

    public $listeners = ['refresh' => '$refresh'];

    protected $rules = [
        'tagSelect' => 'required',
    ];

    public function mount($client, $dossier)
    {
        $this->dossier = $dossier;
    }

    public function addTag(TagsRepositoryContract $repTag)
    {
        $this->validate();

        foreach ($this->tagSelect as $tag)
        {
            $modelTag = $repTag->fetchById($tag);
            $repTag->attachDossier($this->dossier, $modelTag);
        }


        $this->tagSelect = [];
        $this->emit('refresh');
    }

    public function deleteTag(TagsRepositoryContract $repTag, $idTag)
    {
        $tag = $repTag->fetchById($idTag);
        $repTag->detachTag($this->dossier, $tag);

        $this->emit('refresh');
}


    public function render(TagsRepositoryContract $repTag)
    {
        $this->tags = $repTag->All();
        $this->tagsDossier = $repTag->getByDossier($this->dossier);

        return view('crmautocar::livewire.select-tags');
    }
}
