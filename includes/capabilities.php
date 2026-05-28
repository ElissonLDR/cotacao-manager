<?php

if (!defined('ABSPATH')) exit;

if (!defined('COTACAO_CAP')) {
    define('COTACAO_CAP', 'manage_cotacoes');
}

function cotacao_user_can_manage() {
    return current_user_can(COTACAO_CAP);
}

function cotacao_grant_default_caps() {
    $role = get_role('administrator');

    if ($role && !$role->has_cap(COTACAO_CAP)) {
        $role->add_cap(COTACAO_CAP);
    }
}

function cotacao_register_members_cap_group() {
    if (!function_exists('members_register_cap_group')) {
        return;
    }

    members_register_cap_group('cotacao-manager', [
        'label'    => __('Cotação Manager', 'cotacao-manager'),
        'caps'     => [COTACAO_CAP],
        'icon'     => 'dashicons-chart-line',
        'priority' => 30,
    ]);
}

function cotacao_register_members_cap() {
    if (!function_exists('members_register_cap')) {
        return;
    }

    members_register_cap(COTACAO_CAP, [
        'label' => __('Gerenciar cotações', 'cotacao-manager'),
        'group' => 'cotacao-manager',
    ]);
}

add_action('init', 'cotacao_grant_default_caps', 5);

add_filter('option_page_capability_cotacao_group', function () {
    return COTACAO_CAP;
});

add_action('members_register_cap_groups', 'cotacao_register_members_cap_group');
add_action('members_register_caps', 'cotacao_register_members_cap');
