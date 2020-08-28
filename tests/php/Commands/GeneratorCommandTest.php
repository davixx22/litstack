<?php

namespace Tests\Commands;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Console\CastMakeCommand;
use Illuminate\Support\Facades\File;
use Tests\BackendTestCase;

class GeneratorCommandTest extends BackendTestCase
{
    public function tearDown(): void
    {
        File::deleteDirectory(base_path('lit/app/Http/Livewire'));
        File::deleteDirectory(base_path('lit/resources/views/livewire'));
        File::deleteDirectory(base_path('lit/app/Jobs'));
        File::deleteDirectory(base_path('lit/app/View'));
        File::deleteDirectory(base_path('lit/app/Casts'));

        parent::tearDown();
    }

    /** @test */
    public function it_creates_livewire_component_and_view()
    {
        $this->artisan('lit:livewire', ['name' => 'foo']);
        $this->assertFileExists(base_path('lit/app/Http/Livewire/Foo.php'));
        $this->assertFileExists(base_path('lit/resources/views/livewire/foo.blade.php'));
        $this->assertTrue(class_exists(\Lit\Http\Livewire\Foo::class));
    }

    /** @test */
    public function it_passes_inline_to_livewire_component()
    {
        $this->artisan('lit:livewire', ['name' => 'foo', '--inline' => true]);
        $this->assertFileExists(base_path('lit/app/Http/Livewire/Foo.php'));
        $this->assertFileDoesNotExist(base_path('lit/resources/views/livewire/foo.blade.php'));
    }

    /** @test */
    public function it_fixes_livewire_component_view_namespace()
    {
        $this->artisan('lit:livewire', ['name' => 'foo']);
        $this->assertFileExists(base_path('lit/app/Http/Livewire/Foo.php'));
        $this->assertStringContainsString('lit::livewire.foo', File::get(base_path('lit/app/Http/Livewire/Foo.php')));
    }

    /** @test */
    public function it_creates_job()
    {
        $this->artisan('lit:job', ['name' => 'foo']);
        $this->assertFileExists(base_path('lit/app/Jobs/Foo.php'));
        $this->assertTrue(class_exists(\Lit\Jobs\Foo::class));
    }

    /** @test */
    public function it_creates_cast()
    {
        if (! class_exists(CastMakeCommand::class)) {
            $this->markTestSkipped('Cast command not available in Laravel '.Application::VERSION);
        }
        $this->artisan('lit:cast', ['name' => 'foo']);
        $this->assertFileExists(base_path('lit/app/Casts/Foo.php'));
        $this->assertTrue(class_exists(\Lit\Casts\Foo::class));
    }

    /** @test */
    public function it_create_component_and_its_view()
    {
        $this->artisan('lit:component', ['name' => 'Foo']);
        $this->assertFileExists(base_path('lit/app/View/Components/Foo.php'));
        $this->assertFileExists(base_path('lit/resources/views/components/foo.blade.php'));
        $this->assertTrue(class_exists(\Lit\View\Components\Foo::class));
    }

    /** @test */
    public function it_fixes_component_view_namespace()
    {
        $this->artisan('lit:component', ['name' => 'Foo']);
        $view = (new \Lit\View\Components\Foo())->render();
        $this->assertSame('lit::components.foo', $view->getName());
    }
}
