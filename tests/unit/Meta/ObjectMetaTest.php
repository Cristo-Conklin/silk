<?php

use Silk\Meta\Meta;
use Silk\Meta\ObjectMeta;
use Illuminate\Support\Collection;

class ObjectMetaTest extends WP_UnitTestCase
{
    /**
     * @test
     */
    public function it_can_get_a_dedicated_meta_object_for_a_given_key()
    {
        $post_id = $this->factory->post->create();

        $postMeta = new ObjectMeta('post', $post_id);

        $this->assertInstanceOf(Meta::class, $postMeta->get('some_meta_key'));
    }

    /**
     * @test
     */
    public function it_can_return_all_meta_as_a_collection()
    {
        $post_id = $this->factory->post->create();

        $meta = new ObjectMeta('post', $post_id);

        $this->assertInstanceOf(Collection::class, $meta->collect());

        foreach ($meta->collect() as $metaForKey) {
            $this->assertInstanceOf(Meta::class, $metaForKey);
        }
    }
}
