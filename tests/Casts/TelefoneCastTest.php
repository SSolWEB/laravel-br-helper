<?php
namespace SSolWEB\LaravelBrFormatter\Tests\Casts;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;
use SSolWEB\LaravelBrFormatter\Casts\TelefoneCast;

class TelefoneCastTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function testTelefoneCast()
    {
        $model = new class extends Model {
            protected $casts = ['telefone' => TelefoneCast::class];
        };
        $model->telefone = '1133334444';
        $this->assertEquals('1133334444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 3333-4444', $model->telefone);
        // telefone móvel
        $model->telefone = '11999994444';
        $this->assertEquals('11999994444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
    }

    public function testTelefoneFormated()
    {
        $model = new class extends Model {
            protected $casts = ['telefone' => TelefoneCast::class];
        };
        $model->telefone = '(11) 3333-4444';
        $this->assertEquals('1133334444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 3333-4444', $model->telefone);
        // telefone móvel
        $model->telefone = '(11) 99999-4444';
        $this->assertEquals('11999994444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
    }

    public function testFillable()
    {
        $model = new class (['telefone' => '1133334444']) extends Model {
            protected $fillable = ['telefone'];
            protected $casts = ['telefone' => TelefoneCast::class];
        };
        $this->assertEquals('1133334444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 3333-4444', $model->telefone);
        // telefone móvel
        $model = new class (['telefone' => '11999994444']) extends Model {
            protected $fillable = ['telefone'];
            protected $casts = ['telefone' => TelefoneCast::class];
        };
        $this->assertEquals('11999994444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
    }

    public function testNull()
    {
        $model = new class extends Model {
            protected $casts = ['telefone' => TelefoneCast::class];
        };
        $model->telefone = null;
        $this->assertEquals(null, $model->getAttributes()['telefone']);
        $this->assertEquals(null, $model->telefone);
    }
}
