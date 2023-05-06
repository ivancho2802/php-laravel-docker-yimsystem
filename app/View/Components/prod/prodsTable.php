<?php

namespace App\View\Components\prod;
use App\Models\Empre;
use App\Models\Inventario;

use Illuminate\View\Component;

class prodsTable extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     * @param array|Inventario $inventarios
     * @param array| $inventarioInicialAcum
     */

    public function __construct(
        public ?string $dateFrom,
        public ?string $dateTo,

        public ?string $dateBegin,
        public ?string $dateEnd,

        public ?Empre $empre,
        public $inventarios,
        public $inventarioInicialAcum,

        public ?string $mes,
        public ?string $ano,
        public ?string $dia,
        public ?string $type,
        public ?string $prod,
        )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.prod.prods-table');
    }
}
