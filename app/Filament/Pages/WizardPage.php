<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;

/**
 * @property Form $form
 */
class WizardPage extends Page
{
    use InteractsWithFormActions;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.wizard-page';

    protected static ?string $title = 'Wizard';

    public array $data = [];

    public function form(Form $form): Form
    {
        return $form;
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->statePath('data')
                    ->schema([
                        Wizard::make([
                            Step::make('Appointment')
                                ->icon('heroicon-o-calendar')
                                ->schema([
                                    Select::make('customer_id')
                                        ->searchable()
                                        ->label('Customer')
                                        ->options([
                                            1 => 'Peter Smith',
                                            2 => 'Jason Bourne',
                                        ]),

                                    TextInput::make('note'),
                                ]),

                            Step::make('Add-ons')
                                ->icon('heroicon-o-plus-small'),
                        ])->registerListeners([
                            'wizard::nextStep' => [
                                function (Wizard $component, string $statePath, int $currentStepIndex) {
                                    dd('State Path: '.$statePath, $this->$statePath);
                                },
                            ],
                        ]),
                    ])
            ),
        ];
    }
}
