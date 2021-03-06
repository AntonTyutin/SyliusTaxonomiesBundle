<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\TaxonomiesBundle\Model;

use PHPSpec2\ObjectBehavior;

/**
 * Taxon spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Taxon extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\TaxonomiesBundle\Model\Taxon');
    }

    function it_implements_Sylius_taxon_interface()
    {
        $this->shouldImplement('Sylius\Bundle\TaxonomiesBundle\Model\TaxonInterface');
    }

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_does_not_belong_to_taxonomy_by_default()
    {
        $this->getTaxonomy()->shouldReturn(null);
    }

    /**
     * @param Sylius\Bundle\TaxonomiesBundle\Model\TaxonomyInterface $taxonomy
     * @param Sylius\Bundle\TaxonomiesBundle\Model\TaxonInterface $root
     */
    function it_allows_assigning_itself_to_taxonomy($taxonomy, $root)
    {
        $taxonomy->getRoot()->willReturn($root);

        $this->setTaxonomy($taxonomy);
        $this->getTaxonomy()->shouldReturn($taxonomy);
    }

    /**
     * @param Sylius\Bundle\TaxonomiesBundle\Model\TaxonomyInterface $taxonomy
     * @param Sylius\Bundle\TaxonomiesBundle\Model\TaxonInterface $root
     */
    function it_allows_detaching_itself_from_taxonomy($taxonomy, $root)
    {
        $taxonomy->getRoot()->willReturn($root);

        $this->setTaxonomy($taxonomy);
        $this->getTaxonomy()->shouldReturn($taxonomy);

        $this->setTaxonomy(null);
        $this->getTaxonomy()->shouldReturn(null);
    }

    function it_has_no_parent_by_default()
    {
        $this->getParent()->shouldReturn(null);
    }

    /**
     * @param Sylius\Bundle\TaxonomiesBundle\Model\TaxonInterface $taxon
     */
    function its_parent_is_mutable($taxon)
    {
        $this->setParent($taxon);
        $this->getParent()->shouldReturn($taxon);
    }

    function it_is_root_by_default()
    {
        $this->shouldBeRoot();
    }

    /**
     * @param Sylius\Bundle\TaxonomiesBundle\Model\TaxonInterface $taxon
     */
    function it_is_not_root_when_has_parent($taxon)
    {
        $this->setParent($taxon);
        $this->shouldNotBeRoot();
    }

    /**
     * @param Sylius\Bundle\TaxonomiesBundle\Model\TaxonInterface $taxon
     */
    function it_is_root_when_has_no_parent($taxon)
    {
        $this->shouldBeRoot();

        $this->setParent($taxon);
        $this->shouldNotBeRoot();
        $this->setParent(null);

        $this->shouldBeRoot();
    }

    function it_is_unnamed_by_default()
    {
        $this->getName()->shouldReturn(null);
    }

    function its_name_is_mutable()
    {
        $this->setName('Brand');
        $this->getName()->shouldReturn('Brand');
    }

    function it_has_no_description_by_default()
    {
        $this->getDescription()->shouldReturn(null);
    }

    function its_description_is_mutable()
    {
        $this->setDescription('This is a list of brands.');
        $this->getDescription()->shouldReturn('This is a list of brands.');
    }

    function it_has_no_slug_by_default()
    {
        $this->getSlug()->shouldReturn(null);
    }

    function its_slug_is_mutable()
    {
        $this->setSlug('t-shirts');
        $this->getSlug()->shouldReturn('t-shirts');
    }

    function it_has_no_permalink_by_default()
    {
        $this->getPermalink()->shouldReturn(null);
    }

    function its_permalink_is_mutable()
    {
        $this->setPermalink('woman-clothing');
        $this->getPermalink()->shouldReturn('woman-clothing');
    }

    function it_initializes_child_taxon_collection_by_default()
    {
        $this->getChildren()->shouldHaveType('Doctrine\Common\Collections\Collection');
    }

    /**
     * @param Sylius\Bundle\TaxonomiesBundle\Model\TaxonInterface $taxon
     */
    function it_allows_to_check_if_given_taxon_is_its_child($taxon)
    {
        $this->hasChild($taxon)->shouldReturn(false);
    }

    /**
     * @param Sylius\Bundle\TaxonomiesBundle\Model\TaxonomyInterface $taxonomy
     * @param Sylius\Bundle\TaxonomiesBundle\Model\TaxonInterface    $taxon
     */
    function it_allows_to_add_child_taxons($taxonomy, $taxon)
    {
        $this->setTaxonomy($taxonomy);

        $taxon->setTaxonomy($taxonomy)->shouldBeCalled();
        $taxon->setParent($this)->shouldBeCalled();

        $this->addChild($taxon);
    }

    /**
     * @param Sylius\Bundle\TaxonomiesBundle\Model\TaxonomyInterface $taxonomy
     * @param Sylius\Bundle\TaxonomiesBundle\Model\TaxonInterface    $taxon
     */
    function it_allows_to_remove_child_taxons($taxonomy, $taxon)
    {
        $this->setTaxonomy($taxonomy);

        $taxon->setTaxonomy($taxonomy)->shouldBeCalled();
        $taxon->setParent($this)->shouldBeCalled();

        $this->addChild($taxon);

        $taxon->setTaxonomy(null)->shouldBeCalled();
        $taxon->setParent(null)->shouldBeCalled();

        $this->removeChild($taxon);
    }
}
