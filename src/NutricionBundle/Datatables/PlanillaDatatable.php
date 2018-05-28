<?php

namespace NutricionBundle\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\BooleanColumn;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\MultiselectColumn;
use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Column\ImageColumn;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;
use Sg\DatatablesBundle\Datatable\Editable\CombodateEditable;
use Sg\DatatablesBundle\Datatable\Editable\SelectEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextareaEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextEditable;

/**
 * Class PlanillaDatatable
 *
 * @package NutricionBundle\Datatables
 */
class PlanillaDatatable extends AbstractDatatable
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->language->set(array(
            'cdn_language_by_locale' => true,
            'language' => 'es'
        ));

        $this->ajax->set(array(
        ));

        $this->options->set(array(
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'order_cells_top' => true,
            'classes' => Style::BOOTSTRAP_3_STYLE, // or Style::BOOTSTRAP_3_STYLE.' table-condensed'
            'paging_type' => Style::FULL_NUMBERS_PAGINATION,
        ));

        $this->features->set(array(
        ));

        $this->columnBuilder
             ->add('cedula', Column::class, array(
                'title' => 'Cedula',
                ))
            ->add('nombre', Column::class, array(
                'title' => 'Nombre',
                ))
            ->add('apellido', Column::class, array(
                'title' => 'Apellido',
                ))  
            ->add('planillas', Column::class, array(
                'title' => 'Monto Total',
                'dql' => '(SELECT SUM({p}.monto) FROM NutricionBundle:Volumenes {p} WHERE {p}.planilla = planilla )',
                'type_of_field' => 'integer',
                'searchable' => true,
                'orderable' => true,
                 ))                               
          
            ->add(null, ActionColumn::class, array(
                'title' => $this->translator->trans('sg.datatables.actions.title'),
                'actions' => array(
                    array(    
                        'route' => 'vp',
                            'route_parameters' => array(
                                'id' => 'id'                                
                         ),                                     
                        'label' => 'PV', 
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Cargar Punto de Volumen',
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'arbol',
                            'route_parameters' => array(
                                'id' => 'id'                                
                         ),  
                        'label' => 'Arbol Genealogico',
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Rango Omega',
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    ),
                     array(
                        'route' => 'diferencial',
                            'route_parameters' => array(
                                'id' => 'id'                                
                         ),  
                        'label' => 'Comisiones',
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Calculo Diferencial',
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    )
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'NutricionBundle\Entity\Planilla';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'planilla_datatable';
    }
}
