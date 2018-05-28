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
            'cdn_language_by_locale' => true
            //'language' => 'de'
        ));

        $this->ajax->set(array(
        ));

        $this->options->set(array(
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'order_cells_top' => true,
        ));

        $this->features->set(array(
        ));

        $this->columnBuilder
            ->add('id', Column::class, array(
                'title' => 'Id',
                ))
            ->add('cedula', Column::class, array(
                'title' => 'Cedula',
                ))
            ->add('nombre', Column::class, array(
                'title' => 'Nombre',
                ))
            ->add('apellido', Column::class, array(
                'title' => 'Apellido',
                ))
            ->add('nacimiento', Column::class, array(
                'title' => 'Nacimiento',
                ))
            ->add('profesion', Column::class, array(
                'title' => 'Profesion',
                ))
            ->add('ocupacion', Column::class, array(
                'title' => 'Ocupacion',
                ))
            ->add('nacionalidad', Column::class, array(
                'title' => 'Nacionalidad',
                ))
            ->add('direccion', Column::class, array(
                'title' => 'Direccion',
                ))
            ->add('ciudad', Column::class, array(
                'title' => 'Ciudad',
                ))
            ->add('estado', Column::class, array(
                'title' => 'Estado',
                ))
            ->add('pais', Column::class, array(
                'title' => 'Pais',
                ))
            ->add('cedulared', Column::class, array(
                'title' => 'Cedulared',
                ))
            ->add('nombrered', Column::class, array(
                'title' => 'Nombrered',
                ))
            ->add('apellidored', Column::class, array(
                'title' => 'Apellidored',
                ))
            ->add('clave', Column::class, array(
                'title' => 'Clave',
                ))
            ->add(null, ActionColumn::class, array(
                'title' => $this->translator->trans('sg.datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'planilla_show',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('sg.datatables.actions.show'), 
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('sg.datatables.actions.show'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'planilla_edit',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('sg.datatables.actions.edit'),
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('sg.datatables.actions.edit'),
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
