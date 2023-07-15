<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LieuRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LieuCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LieuCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Lieu::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/lieu');
        CRUD::setEntityNameStrings('lieu', 'Lieu');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        

        CRUD::column('id');
        CRUD::column('label');
        CRUD::addcolumn(['name' => 'id_type_lieu', 'type' => 'select','label'=>'Type Lieu','entity'=>'lieu','model'=>'App\Models\TypeLieu','attribute'=>'label']);
        CRUD::column('nbr_vip');
        CRUD::column('nbr_reserve');
        CRUD::column('nbr_normal');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation([
            // 'name' => 'required|min:2',
        ]);

        CRUD::field('label');
        CRUD::addfield(['name' => 'id_type_lieu', 'type' => 'select','label'=>'Type Lieu','entity'=>'lieu','model'=>'App\Models\TypeLieu','attribute'=>'label']);
        CRUD::field('nbr_vip');
        CRUD::field('nbr_reserve');
        CRUD::field('nbr_normal');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        CRUD::column('id');
        CRUD::column('label');
        CRUD::addcolumn(['name' => 'id_type_lieu', 'type' => 'select','label'=>'Type Lieu','entity'=>'lieu','model'=>'App\Models\TypeLieu','attribute'=>'label']);
        CRUD::column('nbr_vip');
        CRUD::column('nbr_reserve');
        CRUD::column('nbr_normal');
    }
}
