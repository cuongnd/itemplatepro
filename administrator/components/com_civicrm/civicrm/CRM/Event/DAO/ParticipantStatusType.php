<?php
/*
+--------------------------------------------------------------------+
| CiviCRM version 4.7                                                |
+--------------------------------------------------------------------+
| Copyright CiviCRM LLC (c) 2004-2016                                |
+--------------------------------------------------------------------+
| This file is a part of CiviCRM.                                    |
|                                                                    |
| CiviCRM is free software; you can copy, modify, and distribute it  |
| under the terms of the GNU Affero General Public License           |
| Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
|                                                                    |
| CiviCRM is distributed in the hope that it will be useful, but     |
| WITHOUT ANY WARRANTY; without even the implied warranty of         |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
| See the GNU Affero General Public License for more details.        |
|                                                                    |
| You should have received a copy of the GNU Affero General Public   |
| License and the CiviCRM Licensing Exception along                  |
| with this program; if not, contact CiviCRM LLC                     |
| at info[AT]civicrm[DOT]org. If you have questions about the        |
| GNU Affero General Public License or the licensing of CiviCRM,     |
| see the CiviCRM license FAQ at http://civicrm.org/licensing        |
+--------------------------------------------------------------------+
*/
/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2016
 *
 * Generated from xml/schema/CRM/Event/ParticipantStatusType.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:c129b855ca83f4e0e659f57936b92799)
 */
require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Event_DAO_ParticipantStatusType extends CRM_Core_DAO {
  /**
   * static instance to hold the table name
   *
   * @var string
   */
  static $_tableName = 'civicrm_participant_status_type';
  /**
   * static value to see if we should log any modifications to
   * this table in the civicrm_log table
   *
   * @var boolean
   */
  static $_log = true;
  /**
   * unique participant status type id
   *
   * @var int unsigned
   */
  public $id;
  /**
   * non-localized name of the status type
   *
   * @var string
   */
  public $name;
  /**
   * localized label for display of this status type
   *
   * @var string
   */
  public $label;
  /**
   * the general group of status type this one belongs to
   *
   * @var string
   */
  public $class;
  /**
   * whether this is a status type required by the system
   *
   * @var boolean
   */
  public $is_reserved;
  /**
   * whether this status type is active
   *
   * @var boolean
   */
  public $is_active;
  /**
   * whether this status type is counted against event size limit
   *
   * @var boolean
   */
  public $is_counted;
  /**
   * controls sort order
   *
   * @var int unsigned
   */
  public $weight;
  /**
   * whether the status type is visible to the public, an implicit foreign key to option_value.value related to the `visibility` option_group
   *
   * @var int unsigned
   */
  public $visibility_id;
  /**
   * class constructor
   *
   * @return civicrm_participant_status_type
   */
  function __construct() {
    $this->__table = 'civicrm_participant_status_type';
    parent::__construct();
  }
  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = array(
        'id' => array(
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Participant Status Type ID') ,
          'description' => 'unique participant status type id',
          'required' => true,
        ) ,
        'participant_status' => array(
          'name' => 'name',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Participant Status') ,
          'description' => 'non-localized name of the status type',
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
          'import' => true,
          'where' => 'civicrm_participant_status_type.name',
          'headerPattern' => '',
          'dataPattern' => '',
          'export' => true,
        ) ,
        'label' => array(
          'name' => 'label',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Participant Status Label') ,
          'description' => 'localized label for display of this status type',
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
        ) ,
        'class' => array(
          'name' => 'class',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Participant Status Class') ,
          'description' => 'the general group of status type this one belongs to',
          'maxlength' => 8,
          'size' => CRM_Utils_Type::EIGHT,
          'html' => array(
            'type' => 'Select',
          ) ,
          'pseudoconstant' => array(
            'callback' => 'CRM_Event_PseudoConstant::participantStatusClassOptions',
          )
        ) ,
        'is_reserved' => array(
          'name' => 'is_reserved',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Participant Status Is Reserved?>') ,
          'description' => 'whether this is a status type required by the system',
        ) ,
        'is_active' => array(
          'name' => 'is_active',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Participant Status is Active') ,
          'description' => 'whether this status type is active',
          'default' => '1',
        ) ,
        'is_counted' => array(
          'name' => 'is_counted',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Participant Status Counts?') ,
          'description' => 'whether this status type is counted against event size limit',
        ) ,
        'weight' => array(
          'name' => 'weight',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Order') ,
          'description' => 'controls sort order',
          'required' => true,
        ) ,
        'visibility_id' => array(
          'name' => 'visibility_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Participant Status Visibility') ,
          'description' => 'whether the status type is visible to the public, an implicit foreign key to option_value.value related to the `visibility` option_group',
          'html' => array(
            'type' => 'Select',
          ) ,
          'pseudoconstant' => array(
            'optionGroupName' => 'visibility',
            'optionEditPath' => 'civicrm/admin/options/visibility',
          )
        ) ,
      );
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }
  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }
  /**
   * Returns the names of this table
   *
   * @return string
   */
  static function getTableName() {
    return CRM_Core_DAO::getLocaleTableName(self::$_tableName);
  }
  /**
   * Returns if this table needs to be logged
   *
   * @return boolean
   */
  function getLog() {
    return self::$_log;
  }
  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  static function &import($prefix = false) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'participant_status_type', $prefix, array());
    return $r;
  }
  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  static function &export($prefix = false) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'participant_status_type', $prefix, array());
    return $r;
  }
}
