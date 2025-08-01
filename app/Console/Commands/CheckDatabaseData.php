<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DoorStyle;
use App\Models\DoorColor;
use App\Models\ProductLine;

class CheckDatabaseData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:database-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check database data for door styles, colors, and product lines';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Door Styles ===');
        $doorStyles = DoorStyle::all();
        foreach ($doorStyles as $style) {
            $this->line($style->name . ' (ID: ' . $style->id . ')');
        }

        $this->info('=== Door Colors ===');
        $doorColors = DoorColor::all();
        foreach ($doorColors as $color) {
            $this->line($color->name . ' (ID: ' . $color->id . ')');
        }

        $this->info('=== Product Lines (Style - Color) ===');
        $productLines = ProductLine::with(['doorStyle', 'doorColor'])->get();
        foreach ($productLines as $pl) {
            $this->line($pl->doorStyle->name . ' - ' . $pl->doorColor->name . ' (Style ID: ' . $pl->door_style_id . ', Color ID: ' . $pl->door_color_id . ')');
        }

        $this->info('=== Colors by Style ===');
        foreach ($doorStyles as $style) {
            $this->line($style->name . ':');
            $colors = ProductLine::where('door_style_id', $style->id)
                ->with('doorColor')
                ->get();
            if ($colors->count() > 0) {
                foreach ($colors as $pl) {
                    $this->line('  - ' . $pl->doorColor->name);
                }
            } else {
                $this->line('  - No colors linked');
            }
        }

        $this->info('=== Product Lines Count ===');
        $this->line('Total Product Lines: ' . $productLines->count());
        foreach ($doorStyles as $style) {
            $count = ProductLine::where('door_style_id', $style->id)->count();
            $this->line($style->name . ': ' . $count . ' colors');
        }
    }
} 