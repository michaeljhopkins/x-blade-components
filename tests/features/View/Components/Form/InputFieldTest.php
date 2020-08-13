<?php
namespace Masterix21\XBladeComponents\Tests\features\View\Components\Form;

use Illuminate\Support\Str;
use Masterix21\XBladeComponents\View\Components\Form\InputField;

class InputFieldTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->field = $this->app->make(InputField::class)
            ->resolveView()
            ->with('id', Str::uuid())
            ->with('name', 'test-input-label')
            ->with('label', 'Test label')
            ->with('value', null)
            ->with('errorBag', null)
            ->with('slot', null)
            ->with('readOnly', false)
            ->with('disabled', false)
            ->with('attributes', null);
    }

    /** @test */
    public function it_shown_without_errors()
    {
        $this->assertHtmlContainsSelector(
            $this->field->toHtml(),
            'input#'. $this->field->id
        );
    }

    /** @test */
    public function it_show_the_value()
    {
        $this->field->with('value', 'Hello this is my value');

        tap($this->getFieldElement(), function ($element) {
            $this->assertEquals(
                'Hello this is my value',
                $element->attr('value'),
            );

            $this->assertNull($element->attr('readonly'));
        });
    }

    /** @test */
    public function it_show_a_readonly_field()
    {
        $this->field
            ->with('value', 'Readonly value')
            ->with('readOnly', true);

        $this->assertEquals(
            'readonly',
            $this->getFieldElement()->attr('readonly')
        );
    }

    /** @test */
    public function it_show_a_disabled_field()
    {
        $this->field
            ->with('value', 'Readonly value')
            ->with('disabled', true);

        $this->assertEquals(
            'disabled',
            $this->getFieldElement()->attr('disabled')
        );
    }
}