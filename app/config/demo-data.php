<?php
/**
 * Demo / seed data used by the dashboards until MySQL models are wired.
 * All amounts are XAF. Names and places are Cameroonian.
 */

$TF_DEMO_USER = [
    'id'           => '01XJ00F',
    'name'         => 'John Doe',
    'first_name'   => 'John',
    'email'        => 'johndoe@gmail.com',
    'phone'        => '+237 605 048 910',
    'address'      => 'Yaoundé, Simbock — Mendong',
    'city'         => 'Yaoundé',
    'country'      => 'Cameroon',
    'role'         => 'customer',
    'gender'       => 'Male',
    'payment'      => 'Mobile money',
    'member_since' => '2024',
    'avatar'       => 'Image/profile.jpg',
    'wallet'       => 12400,
];

$TF_ORDERS = [
    ['id' => 'TF-1042', 'item' => 'Mixed Citrus Platter — 6 kg',       'date' => '12 Aug 2026', 'amount' => 6000,  'status' => 'Delivered',   'tone' => 'ok'],
    ['id' => 'TF-1017', 'item' => 'Mature Orange Tree (Valencia)',     'date' => '28 Jul 2026', 'amount' => 30000, 'status' => 'In delivery', 'tone' => 'warn'],
    ['id' => 'TF-1004', 'item' => 'Fresh Orange Juice — 1 L × 4',      'date' => '11 Jul 2026', 'amount' => 7200,  'status' => 'Delivered',   'tone' => 'ok'],
    ['id' => 'TF-0988', 'item' => 'Orchard Box — 1 month',             'date' => '02 Jul 2026', 'amount' => 12000, 'status' => 'Delivered',   'tone' => 'ok'],
    ['id' => 'TF-0961', 'item' => 'Farm Visit & Self-Harvest × 2',     'date' => '18 Jun 2026', 'amount' => 30000, 'status' => 'Completed',   'tone' => 'ok'],
];

$TF_SAVED_OPPORTUNITIES = [
    ['title' => 'Partnership Program', 'status' => 'Under review', 'applied' => '04 Aug 2026', 'icon' => 'fa-handshake'],
    ['title' => 'Mentorship Program',  'status' => 'Accepted',     'applied' => '12 May 2026', 'icon' => 'fa-hands-holding-child'],
];

$TF_MESSAGES = [
    ['from' => 'The Farmer Support', 'preview' => 'Your Valencia tree is out for delivery in Yaoundé today.', 'time' => 'Today · 09:14', 'unread' => true],
    ['from' => 'Amina — Mentorship', 'preview' => 'Shall we visit the Simbock plot on Saturday morning?', 'time' => 'Yesterday', 'unread' => true],
    ['from' => 'Harvest desk',       'preview' => 'Your Orchard Box for August has been packed.', 'time' => '11 Aug', 'unread' => false],
];

$TF_FARMER_PRODUCTS = [
    ['id' => 'p1',  'name' => 'Mature Orange Tree (Valencia)', 'stock' => 18, 'price' => 30000, 'status' => 'Live'],
    ['id' => 'p2',  'name' => 'Mature Tangerine Tree',         'stock' => 11, 'price' => 25000, 'status' => 'Live'],
    ['id' => 'p3',  'name' => 'Fresh Oranges — 5 kg basket',   'stock' => 42, 'price' => 3500,  'status' => 'Live'],
    ['id' => 'p6',  'name' => 'Mixed Citrus Platter — 6 kg',   'stock' => 9,  'price' => 6000,  'status' => 'Low stock'],
    ['id' => 'p7',  'name' => 'Fresh Orange Juice — 1 L',      'stock' => 0,  'price' => 1800,  'status' => 'Sold out'],
    ['id' => 'p11', 'name' => 'Farm Visit & Self-Harvest',     'stock' => 30, 'price' => 15000, 'status' => 'Live'],
];

$TF_FARMER_ORDERS = [
    ['id' => 'TF-1048', 'buyer' => 'Bella Ngwa',          'item' => 'Fresh Oranges — 5 kg × 2', 'amount' => 7000,  'status' => 'To pack',     'city' => 'Yaoundé'],
    ['id' => 'TF-1046', 'buyer' => 'Jean-Claude Mbarga',  'item' => 'Mature Tangerine Tree',     'amount' => 25000, 'status' => 'To deliver',  'city' => 'Bafoussam'],
    ['id' => 'TF-1043', 'buyer' => 'Aminata Salla',       'item' => 'Mixed Citrus Platter',      'amount' => 6000,  'status' => 'To pack',     'city' => 'Bamenda'],
    ['id' => 'TF-1039', 'buyer' => 'Patrick Etoundi',     'item' => 'Farm Visit × 3',            'amount' => 45000, 'status' => 'Confirmed',   'city' => 'Douala'],
];

$TF_ADMIN_USERS = [
    ['id' => '01XJ00F', 'name' => 'John Doe',            'role' => 'Customer', 'city' => 'Yaoundé',   'joined' => '2024', 'status' => 'Active'],
    ['id' => '02BN14K', 'name' => 'Bella Ngwa',          'role' => 'Customer', 'city' => 'Yaoundé',   'joined' => '2025', 'status' => 'Active'],
    ['id' => '03JM22P', 'name' => 'Jean-Claude Mbarga',  'role' => 'Farmer',   'city' => 'Bafoussam', 'joined' => '2024', 'status' => 'Active'],
    ['id' => '04AS09M', 'name' => 'Aminata Salla',       'role' => 'Customer', 'city' => 'Bamenda',   'joined' => '2025', 'status' => 'Active'],
    ['id' => '05PE31D', 'name' => 'Patrick Etoundi',     'role' => 'Farmer',   'city' => 'Douala',    'joined' => '2023', 'status' => 'Active'],
    ['id' => '06NK18T', 'name' => 'Ngono Kesseng',       'role' => 'Admin',    'city' => 'Yaoundé',   'joined' => '2023', 'status' => 'Active'],
];

$TF_APPROVAL_QUEUE = [
    ['vendor' => 'Jean-Claude Mbarga', 'product' => 'Pink Grapefruit Tree',      'price' => 28000, 'submitted' => '24 Aug 2026'],
    ['vendor' => 'Patrick Etoundi',    'product' => 'Honey Tangerine — 4 kg',    'price' => 3200,  'submitted' => '23 Aug 2026'],
    ['vendor' => 'Mballa Farms',       'product' => 'Cold-pressed Lime Juice',   'price' => 2000,  'submitted' => '22 Aug 2026'],
];

$TF_OPPORTUNITY_QUEUE = [
    ['title' => 'Youth harvest crew — seasonal', 'type' => 'Employment',  'from' => 'Farm HR',           'status' => 'Pending'],
    ['title' => 'Retail partner — Douala market', 'type' => 'Partnership', 'from' => 'Kotto Fresh Ltd',   'status' => 'Pending'],
    ['title' => 'Soil clinic — Bafoussam',        'type' => 'Mentorship',  'from' => 'Jean-Claude Mbarga','status' => 'Live'],
];
