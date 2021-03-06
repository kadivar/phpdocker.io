<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace AppBundle\Form\Generator;

use AppBundle\Entity\Generator\MySQLOptions;
use PHPDocker\Project\ServiceOptions\MySQL;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Form for MySQL options.
 *
 * @package AppBundle\Form\Generator
 * @author  Luis A. Pabon Flores
 */
class MySQLType extends AbstractGeneratorType
{
    /**
     * Builds the form definition.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hasMysql', CheckboxType::class, [
                'label'    => 'Enable MySQL',
                'required' => false,
            ])
            ->add('version', ChoiceType::class, [
                'choices'  => array_flip(MySQL::getChoices()),
                'expanded' => false,
                'multiple' => false,
                'label'    => 'Version',
            ])
            ->add('rootPassword', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Password for root user'],
            ])
            ->add('databaseName', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Your app\'s database name'],
            ])
            ->add('username', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Your app\'s database username'],
            ])
            ->add('password', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Your app\'s database password'],
            ]);
    }

    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     *
     * @return string
     */
    protected function getDataClass()
    {
        return MySQLOptions::class;
    }

    /**
     * @return callable
     */
    protected function getValidationGroups(): callable
    {
        return function (FormInterface $form) {
            /** @var MySQLOptions $data */
            $data   = $form->getData();
            $groups = ['Default'];

            if ($data->hasMysql() === true) {
                $groups[] = 'mysqlOptions';
            }

            return $groups;
        };
    }
}
