<?php

namespace Tests\Unit;

use App\Fruta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class FrutasTest extends TestCase
{

    use RefreshDatabase;


    protected $fruit;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fruit = factory(Fruta::class)->create();
    }

    /**
     * Probar edicion con un caso correcto.
     *
     * @return void
     */
    public function testSuccessEditApi()
    {
        $edit_elements = ['name' => 'nueva', 'size' => 'pequeño', 'color' => 'test'];
        $response = $this->json('PUT', '/api/frutas/'.$this->fruit->id, $edit_elements);

        $response
            ->assertStatus(200)
            ->assertJson(['message' => 'success']);
        $this->assertDatabaseHas($this->fruit->getTable(),$edit_elements);
    }

    /**
     * Probar edicion con un caso erroneo en la selecciona de tamaño.
     *
     * @return void
     */
    public function testErrorSizeEditApi()
    {
        $edit_elements = ['name' => 'nueva', 'size' => 'pequeñas', 'color' => ''];
        $old_fruit = ['name' => $this->fruit->name, 'size' => $this->fruit->size, 'color' => $this->fruit->color];
        $response = $this->json('PUT', '/api/frutas/'.$this->fruit->id, $edit_elements);

        $response
            ->assertStatus(422)
            ->assertJson([
                "message"=> "The given data was invalid.",
                "errors"=> ["size"=> ["The selected size is invalid."]]
            ]);
        $this->assertDatabaseHas($this->fruit->getTable(),$old_fruit);
        $this->assertDatabaseMissing($this->fruit->getTable(),$edit_elements);
    }

    /**
     * Probar edicion con un caso erroneo fruta sin nombre.
     *
     * @return void
     */
    public function testErrorNameEditApi()
    {
        $edit_elements = ['name' => null, 'size' => 'pequeño', 'color' => ''];
        $old_fruit = ['name' => $this->fruit->name, 'size' => $this->fruit->size, 'color' => $this->fruit->color];
        $response = $this->json('PUT', '/api/frutas/'.$this->fruit->id, $edit_elements);

        $response
            ->assertStatus(422)
            ->assertJson([
                "message"=> "The given data was invalid.",
                "errors"=> ["name"=> ["The name field is required."]]
            ]);
        $this->assertDatabaseHas($this->fruit->getTable(),$old_fruit);
        $this->assertDatabaseMissing($this->fruit->getTable(),$edit_elements);

    }

    /**
     * Probar edicion con un caso erroneo fruta no existente.
     *
     * @return void
     */
    public function testErrorNotFoundEditApi()
    {
        $edit_elements = ['name' => 'nueva', 'size' => 'pequeño', 'color' => 'test'];
        $old_fruit = ['name' => $this->fruit->name, 'size' => $this->fruit->size, 'color' => $this->fruit->color];
        $response = $this->json('PUT', '/api/frutas/0', $edit_elements);

        $response->assertStatus(404);
        $this->assertDatabaseHas($this->fruit->getTable(),$old_fruit);
        $this->assertDatabaseMissing($this->fruit->getTable(),$edit_elements);

    }
}
