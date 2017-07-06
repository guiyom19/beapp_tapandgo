<?php

/* pages/home.twig */
class __TwigTemplate_9c25798ed0997767f3c001ba7311e1b969889873074bf6504b44b05b44428a01 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
    }

    public function getTemplateName()
    {
        return "pages/home.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/home.twig", "D:\\guiyom\\_perso\\beApp\\TapAndGo\\app\\views\\pages\\home.twig");
    }
}
