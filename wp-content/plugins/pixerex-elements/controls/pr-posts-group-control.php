<?php

// Group controle for pixerex posts elements

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

new PR_Helper;

if( class_exists( 'Elementor\Plugin' ) ) :
    class PR_Posts_Group_Control extends Group_Control_Base {

        protected static $fields;

        public static function get_type() {
            return 'prposts';
        }

        public static function on_export_remove_setting_from_element( $element, $control_id ) {
            unset( $element['settings'][ $control_id . '_authors' ] );

            foreach ( Utils::get_post_types() as $post_type => $label ) {
                $taxonomy_filter_args = [
                    'show_in_nav_menus' => true,
                    'object_type' => [ $post_type ],
                ];

                $taxonomies = get_taxonomies( $taxonomy_filter_args, 'objects' );

                foreach ( $taxonomies as $taxonomy => $object ) {
                    unset( $element['settings'][ $control_id . '_' . $taxonomy . '_ids' ] );
                }
            }

            return $element;
        }

        protected function init_fields() {
            $fields = [];

            $fields['post_type'] = [
                'label' => __( 'Source', 'pixerex' ),
                'type' => Controls_Manager::SELECT,
            ];

            $fields['authors'] = [
                'label' => __( 'Author', 'pixerex' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => [],
                'options' => $this->get_authors(),
            ];

            return $fields;
        }

        protected function prepare_fields( $fields ) {

            $post_types = pr_get_post_types();

            $post_types_options = $post_types;

            $fields['post_type']['options'] = $post_types_options;

            $fields['post_type']['default'] = key( $post_types );

            $taxonomy_filter_args = [
                'show_in_nav_menus' => true,
            ];

            if ( ! empty( $args['post_type'] ) ) {
                $taxonomy_filter_args['object_type'] = [ $args['post_type'] ];
            }

            $taxonomies = get_taxonomies( $taxonomy_filter_args, 'objects' );

            foreach ( $taxonomies as $taxonomy => $object ) {
                $taxonomy_args = [
                    'label' => $object->label,
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'object_type' => $taxonomy,
                    'options' => [],
                    'condition' => [
                        'post_type' => $object->object_type,
                    ],
                ];

                $options = [];

                $taxonomy_args['type'] = Controls_Manager::SELECT2;

                $terms = get_terms( $taxonomy );

                foreach ( $terms as $term ) {
                    $options[ $term->term_id ] = $term->name;
                }

                $taxonomy_args['options'] = $options;

                $fields[ $taxonomy . '_ids' ] = $taxonomy_args;
            }

            unset( $fields['post_format_ids'] );

            return parent::prepare_fields( $fields );
        }

        /**
         * All authors name and ID, who published at least 1 post.
         * @return array
         */
        public function get_authors() {
            $user_query = new \WP_User_Query(
                [
                    'who' => 'authors',
                    'has_published_posts' => true,
                    'fields' => [
                        'ID',
                        'display_name',
                    ],
                ]
            );

            $authors = [];

            foreach ( $user_query->get_results() as $result ) {
                $authors[ $result->ID ] = $result->display_name;
            }

            return $authors;
        }

        protected function get_default_options() {
            return [
                'popover' => false,
            ];
        }
    }
endif;

class PR_Helper {

    public static function get_query_args( $control_id, $settings ) {
        $defaults = [
            $control_id . '_post_type' => 'post',
            'orderby' => 'date',
            'order' => 'desc',
            'posts_per_page' => 3,
            'offset' => 0,
        ];

        $settings = wp_parse_args( $settings, $defaults );

        $post_type = $settings[ $control_id . '_post_type' ];

        $except_ids = [];
        if($settings['pr_post_except'] != '' OR $settings['pr_post_except'] != null){
            $except_ids = explode(',',$settings['pr_post_except']);
        }
        $query_args = [
            'orderby' => $settings['pr_post_orderby'],
            'order' => $settings['pr_post_order'],
            'ignore_sticky_posts' => 1,
            'post__not_in' => $except_ids,
            'post_status' => 'publish', // Hide drafts/private posts for admins
        ];

        $query_args['post_type'] = $post_type;
        $query_args['posts_per_page'] = $settings['pr_posts_count'];
        $query_args['tax_query'] = [];

        $query_args['offset'] = $settings['pr_post_offset'];

        $taxonomies = get_object_taxonomies( $post_type, 'objects' );

        foreach ( $taxonomies as $object ) {
            $setting_key = $control_id . '_' . $object->name . '_ids';

            if ( ! empty( $settings[ $setting_key ] ) ) {
                $query_args['tax_query'][] = [
                    'taxonomy' => $object->name,
                    'field' => 'term_id',
                    'terms' => $settings[ $setting_key ],
                ];
            }
        }

        if ( ! empty( $settings[ $control_id . '_authors' ] ) ) {
            $query_args['author__in'] = $settings[ $control_id . '_authors' ];
        }

        $post__not_in = [];
        if ( ! empty( $settings['post__not_in'] ) ) {
            $post__not_in = array_merge( $post__not_in, $settings['post__not_in'] );
            $query_args['post__not_in'] = $post__not_in;
        }

        if( isset( $query_args['tax_query'] ) && count( $query_args['tax_query'] ) > 1 ) {
            $query_args['tax_query']['relation'] = 'OR';
        }

        return $query_args;
    }

}





