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
 * Class DocumentoDatatable
 *
 * @package NutricionBundle\Datatables
 */
class DocumentoDatatable extends AbstractDatatable
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
                              
           
            ->add(null, ActionColumn::class, array(
                'title' => $this->translator->trans('sg.datatables.actions.title'),
                'actions' => array(
                    array(    
                        'route' => 'informeplanilla',
                            'route_parameters' => array(
                                'id' => 'id'                                
                         ),                                     
                        'label' => 'Planilla',
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Planilla',
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    ),


                    array(    
                        'route' => 'eliminar',
                            'route_parameters' => array(
                                'cedula' => 'cedula'                                
                         ),                                     
                        'label' => 'Eliminar',
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Eliminar',
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button',
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
        return 'documento_datatable';
    }
}
