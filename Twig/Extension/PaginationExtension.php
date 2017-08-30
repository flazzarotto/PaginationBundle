<?php

namespace TangoMan\PaginationBundle\Twig\Extension;

use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginationExtension extends \Twig_Extension
{
    /**
     * @var \Twig_Environment
     */
    private $template;

    /**
     * PaginationExtension constructor.
     *
     * @param \Twig_Environment $template
     */
    public function __construct(\Twig_Environment $template)
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tangoman_pagination';
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'pagination', [$this, 'paginationFunction'], ['is_safe' => ['html'],]
            ),
        ];
    }

    /**
     * @param Paginator $paginator
     * @param string    $template
     *
     * @return string
     */
    public function paginationFunction(Paginator $paginator, $template = 'default')
    {
        $templates = [
            'default',
            'smart',
            'meta',
            'select',
            'select_with_icon',
        ];

        if (in_array($template, $templates)) {
            $template = '@TangoManPagination/'.$template.'.html.twig';
        }

        return $this->template->render(
            $template,
            [
                'pages' => ceil($paginator->count() / $paginator->getQuery()->getMaxResults()),
            ]
        );
    }
}
