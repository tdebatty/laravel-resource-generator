<?php
use Illuminate\Support\Str;

$model = strtolower($Model);
$models = Str::plural($model);
$Models = Str::plural($Model);
?>
<?= '<?php' ?>

namespace App\Http\Controllers;

use App\<?= $Model ?>;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class <?= $Model ?>Controller extends Controller
{

    public function __construct()
    {
        // Uncomment to require authentication
        // $this->middleware('auth');
    }

    /**
     * Get validation rules for an incoming request.
     */
    protected function rules() : array
    {
        return [
            'name' => 'required|string|max:255'
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("<?= $model ?>.index", ["<?= $models ?>" => <?= $Model ?>::all()->sortBy("name")]);
    }

    /**
     * Show the form for creating a new resource.
     * We use the same view for create and update => provide an empty <?= $Model ?>.
     *
     */
    public function create()
    {
        return view("<?= $model ?>.edit", ["<?= $model ?>" => new <?= $Model ?>()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());

        $<?= $model ?> = new <?= $Model ?>();
        $<?= $model ?>->name = $request->name;
        $<?= $model ?>->save();
        return redirect(action('<?= $Model ?>Controller@index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(<?= $Model ?> $<?= $model ?>)
    {
        return view("<?= $model ?>.show", ["<?= $model ?>" => $<?= $model ?>]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(<?= $Model ?> $<?= $model ?>)
    {
        return view("<?= $model ?>.edit", ["<?= $model ?>" => $<?= $model ?>]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, <?= $Model ?> $<?= $model ?>)
    {
        $request->validate($this->rules());

        $<?= $model ?>->name = $request->name;
        $<?= $model ?>->save();
        return redirect(action('<?= $Model ?>Controller@index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(<?= $Model ?> $<?= $model ?>)
    {
        $<?= $model ?>->delete();
        return redirect(action("<?= $Model ?>Controller@index"));
    }
}
