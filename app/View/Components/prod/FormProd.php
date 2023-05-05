<?php

namespace App\View\Components\prod;

use Illuminate\View\Component;

class FormProd extends Component
{
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?string $fkInventario,
        public ?string $codigo,
        public ?string $nomFkInventario,
        public ?string $costo,
        public ?string $pmpvj,
        public ?string $cantidad,
        public ?string $stock,
        public ?string $tipoCompra,
        public ?string $type,
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
        return view('components.prod.form-prod');
    }
}
