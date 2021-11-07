<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $anotherUser;

    protected function setUp():void
    {
        parent::setUp();

        // tworzymy użytkownika w obrębie całego testu
        $this->user = User::factory()->create();
        $this->anotherUser = User::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_only_auth_user_can_show_todos_and_create_form()
    {
        // sprawdzam, czy niezalogowany użytkownik może zobaczyć formularz i listę zadań:
        $response = $this->get('/todo');

        $response->assertRedirect('login');

        // sprawdzam, czy zalogowany użytkownik może zobaczyć formularz i listę zadań
        $response = $this->actingAs($this->user)->get('/todo');

        $response->assertStatus(200);
        $response->assertSeeText('Zadania:');
    }

    public function test_authenticate_user_can_add_todos()
    {
        // niezalogowany użytkownik nie może utworzyć nowego zadania
        $response = $this
            ->post('/todo', ['title' => 'Testowy todos', 'status' => 'in_progress']);

        $response->assertRedirect('login');

        // zalogowany użytkownik może utworzyć nowe zadanie
        $response = $this->actingAs($this->user)
            ->post('/todo', ['title' => 'Testowy todos', 'status' => 'in_progress']);

        $response->assertCreated();
        $this->assertDatabaseCount('todos', 1);
    }

    public function test_authenticate_user_can_update_only_his_own_todo()
    {
        // tworzymy zadania do edycji
        Todo::unsetEventDispatcher(); // pomijamy observer, który przypisuje w user_id zalogowanego użytkownika

        Todo::factory()->create(['user_id' => $this->user->id]); // id 2
        Todo::factory()->create(['user_id' => $this->anotherUser->id]); // id 3

        // niezalogowany użytkownik nie może aktualizować żadnego zadania
        $response = $this->put('todo/2', ['title' => 'zmiana tytułu' , 'status' => 'in_progress']);

        $response->assertRedirect('login');

        // zalogowany użytkownik nie może aktualizować nie swojego zadania
        $response = $this->actingAs($this->user)
            ->put('todo/3', ['title' => 'zmiana tytułu' , 'status' => 'in_progress']);

        $response->assertStatus(404);

        // zalogowany użytkownik może aktualizować swoje zadanie
        $response = $this->actingAs($this->user)
            ->put('todo/2', ['title' => 'zmiana tytułu' , 'status' => 'in_progress']);

        $response->assertOk();
        $this->assertDatabaseHas('todos', ['title' => 'zmiana tytułu' , 'status' => 'in_progress']);
    }

    public function test_authenticate_user_can_delete_only_his_own_todo()
    {
        // tworzymy zadania do edycji
        Todo::unsetEventDispatcher(); // pomijamy observer, który przypisuje w user_id zalogowanego użytkownika

        Todo::factory()->create(['user_id' => $this->user->id]); // id 4
        Todo::factory()->create(['user_id' => $this->anotherUser->id]); // id 5

        // niezalogowany użytkownik nie może usunąć żadnego zadania
        $response = $this->delete('todo/4');

        $response->assertRedirect('login');

        // zalogowany użytkownik nie może aktualizować nie swojego zadania
        $response = $this->actingAs($this->user)->delete('todo/5');

        $response->assertStatus(404);

        // zalogowany użytkownik może aktualizować swoje zadanie
        $response = $this->actingAs($this->user)->delete('todo/4');

        $response->assertRedirect(route('todo.index'));
        $response->assertSessionHas('message');
    }
}
