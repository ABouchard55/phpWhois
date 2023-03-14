<?php

/**
 * @license   See LICENSE file
 * @copyright Copyright (C)1999,2005 easyDNS Technologies Inc. & Mark Jeftovic
 * @copyright Maintained by David Saez
 * @copyright Copyright (c) 2014 Dmitry Lukashin
 * @copyright Copyright (c) 2020 Joshua Smith
 */

namespace phpWhois\Handlers;

class FrHandler extends AbstractHandler
{

    public function parse(array $data_str, string $query): array
    {
        $translate = [
            'fax-no'      => 'fax',
            'e-mail'      => 'email',
            'nic-hdl'     => 'handle',
            'ns-list'     => 'handle',
            'person'      => 'name',
            'address'     => 'address.',
            'descr'       => 'desc',
            'anniversary' => '',
            'domain'      => 'name',
            'last-update' => 'changed',
            'registered'  => 'created',
            'Expiry Date' => 'expires',
            'country'     => 'address.country',
            'registrar'   => 'sponsor',
            'role'        => 'organization',
        ];

        $contacts = [
            'admin-c'  => 'admin',
            'tech-c'   => 'tech',
            'zone-c'   => 'zone',
            'holder-c' => 'owner',
            'nsl-id'   => 'nserver',
        ];

        $reg = $this->generic_parser_a($data_str['rawdata'], $translate, $contacts, 'domain', 'dmY');

        if (isset($reg['nserver'])) {
            $reg['domain'] = array_merge($reg['domain'], $reg['nserver']);
            unset($reg['nserver']);
        }

        $r = [
            'rawdata' => $data_str['rawdata'],
        ];

        $r['regrinfo'] = $reg;
        $r['regyinfo'] = [
            'referrer'  => 'http://www.nic.fr',
            'registrar' => 'AFNIC',
        ];

        return $r;
    }
}
