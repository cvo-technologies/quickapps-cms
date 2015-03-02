<?php
trait RolesSchemaTrait
{

    protected $_fields = [
  '_constraints' => 
  [
    'primary' => 
    [
      'type' => 'primary',
      'columns' => 
      [
        0 => 'id',
      ],
      'length' => 
      [
      ],
    ],
    'name' => 
    [
      'type' => 'unique',
      'columns' => 
      [
        0 => 'name',
      ],
      'length' => 
      [
      ],
    ],
  ],
  'id' => 
  [
    'type' => 'integer',
    'length' => 11,
    'unsigned' => false,
    'null' => false,
    'default' => NULL,
    'comment' => '',
    'autoIncrement' => true,
    'precision' => NULL,
  ],
  'slug' => 
  [
    'type' => 'string',
    'length' => 50,
    'null' => false,
    'default' => NULL,
    'comment' => '',
    'precision' => NULL,
    'fixed' => NULL,
  ],
  'name' => 
  [
    'type' => 'string',
    'length' => 128,
    'null' => false,
    'default' => NULL,
    'comment' => '',
    'precision' => NULL,
    'fixed' => NULL,
  ],
];

    protected $_records = [
  0 => 
  [
    'id' => 1,
    'slug' => 'administrator',
    'name' => 'Administrator',
  ],
  1 => 
  [
    'id' => 2,
    'slug' => 'authenticated ',
    'name' => 'Authenticated User',
  ],
  2 => 
  [
    'id' => 3,
    'slug' => 'anonymous',
    'name' => 'Anonymous User',
  ],
];

    public function fields()
    {
        foreach ($this->_fields as $name => $info) {
            if (!empty($info['autoIncrement'])) {
                $this->_fields[$name]['length'] = null;
            }
        }
        return $this->_fields;
    }

    public function records()
    {
        return $this->_records;
    }
}

class RolesSchema
{

    use RolesSchemaTrait;

}