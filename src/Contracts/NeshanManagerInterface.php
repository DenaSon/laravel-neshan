<?php
namespace Denason\Neshan\Contracts;
interface NeshanManagerInterface
{
    /**
     * Get the Static Map service instance.
     *
     * @return StaticMapInterface
     */
    public function staticMap(): StaticMapInterface;

    /**
     * Get the Search service instance.
     *
     * @return SearchInterface
     */
    public function search(): SearchInterface;
}
