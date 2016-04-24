<?php

namespace Tests\AppBundle\Util; 

use AppBundle\Util\ValueToBooleanConverter; 

/**
 * Test class for util class ValueToBooleanConverter 
 * 
 * @author Rémi Houdelette <b0ulzy.todo@gmail.com>
 */
class ValueToBooleanConverterTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * Test convert method with true value
     * 
     * @param mixed $value
     * 
     * @dataProvider trueValuesProvider
     */
    public function testConvertWithTrueValue($value) 
    {
        $boolean = ValueToBooleanConverter::convert($value); 
        $this->assertTrue($boolean); 
    } 

    /**
     * Test convert method with false value
     * 
     * @param mixed $value
     * 
     * @dataProvider falseValuesProvider
     */
    public function testConvertWithFalseValue($value) 
    {
        $boolean = ValueToBooleanConverter::convert($value); 
        $this->assertFalse($boolean); 
    } 

    /**
     * Test convert method with wrong value
     * 
     * @expectedException \InvalidArgumentException
     */
    public function testConvertWithWrongValue() 
    {
        ValueToBooleanConverter::convert('wrong'); 
    } 

    /**
     * Get true values
     * 
     * @return array
     */
    public function trueValuesProvider() 
    {
        return array(
            array(true), 
            array('true'), 
            array('yes'), 
            array('on'), 
            array(1), 
            array('1')
        ); 
    } 

    /**
     * Get false values
     * 
     * @return array
     */
    public function falseValuesProvider() 
    {
        return array(
            array(false), 
            array('false'), 
            array('no') , 
            array('off'), 
            array(0), 
            array('0') 
        );
    }
}
