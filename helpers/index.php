<?php

function get_menus() {
    return array(
        array(
            'id' => '1.1',
            'name' => 'Item 1.1',
            'order' => 1,
            'parent' => 0,
            'children' => [
                [
                    'id' => '2.1',
                    'name' => 'Item 2.1',
                    'order' => 1,
                    'parent' => '1.1',
                    'children' => []
                ],
                [
                    'id' => '2.2',
                    'name' => 'Item 2.2',
                    'order' => 2,
                    'parent' => '1.1',
                    'children' => [
                        [
                            'id' => '3.1',
                            'name' => 'Item 3.1',
                            'order' => 1,
                            'parent' => '2.2',
                            'children' => []
                        ],
                        [
                            'id' => '3.2',
                            'name' => 'Item 3.2',
                            'order' => 2,
                            'parent' => '2.2',
                            'children' => []
                        ],
                        [
                            'id' => '3.3',
                            'name' => 'Item 3.3',
                            'order' => 3,
                            'parent' => '2.2',
                            'children' => []
                        ],
                        [
                            'id' => '3.4',
                            'name' => 'Item 3.4',
                            'order' => 4,
                            'parent' => '2.2',
                            'children' => []
                        ],
                    ]
                ]
            ],
        ),
        array(
            'id' => '1.2',
            'name' => 'Item 1.2',
            'order' => 2,
            'parent' => 0,
            'children' => [],
        ),
        array(
            'id' => '1.3',
            'name' => 'Item 1.3',
            'order' => 3,
            'parent' => 0,
            'children' => [],
        ),
        array(
            'id' => '1.4',
            'name' => 'Item 1.4',
            'order' => 4,
            'parent' => 0,
            'children' => [
                [
                    'id' => '2.3',
                    'name' => 'Item 2.3',
                    'order' => 1,
                    'parent' => '1.4',
                    'children' => []
                ],
                [
                    'id' => '2.4',
                    'name' => 'Item 2.4',
                    'order' => 2,
                    'parent' => '1.4',
                    'children' => []
                ],
                [
                    'id' => '2.5',
                    'name' => 'Item 2.5',
                    'order' => 3,
                    'parent' => '1.4',
                    'children' => []
                ],
                [
                    'id' => '2.6',
                    'name' => 'Item 2.6',
                    'order' => 4,
                    'parent' => '1.4',
                    'children' => []
                ],
            ],
        ),
        array(
            'id' => '1.5',
            'name' => 'Item 1.5',
            'order' => 5,
            'parent' => 0,
            'children' => [],
        )
    );
}

if (! function_exists('build_tree')) {
    function build_tree($elements, $parent = 0) {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent'] === $parent) {
                $children = build_tree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }
}

if (! function_exists('build_sortable_list')) {
    function build_sortable_list($items, $is_root = true, $id = 0) {
        $list = '<ul '.set_sortable_list_attr($is_root, $id).' class="list-group nested-sortable">';
        foreach ($items as $item) {
            $list .= '<li data-id="'.$item['id'].'" class="list-group-item" style="margin-top: 5px;">
                '.$item['name'].'
                '.(!empty($item['children']) ? build_sortable_list($item['children'], $is_root = false, $id = $item['id']) : '').'
            </li>';
        }
        $list .= '</ul>';
        return $list;
    }
}

if (! function_exists('set_sortable_list_attr')) {
    function set_sortable_list_attr($is_root, $id = 0) {
        if ($is_root) {
            return 'id="wrapper-nested-sortable" data-parent-id="0"';
        }
        return 'data-parent-id="'.$id.'"';
    }
}