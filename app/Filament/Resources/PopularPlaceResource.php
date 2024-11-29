<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PopularPlaceResource\Pages;
use App\Filament\Resources\PopularPlaceResource\RelationManagers;
use App\Forms\Components\GoogleMapField;
use App\Models\PopularPlace;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;

class PopularPlaceResource extends Resource
{
    protected static ?string $model = PopularPlace::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function getLabel(): ?string
    {
        return __('Popular Place');  // Translation function works here
    }
    public static function getPluralLabel(): ?string
    {
        return __("Popular Places");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make(__('Place Informations'))
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label(__("Name"))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->label(__("Description"))
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('address')
                                            ->label(__('Address'))
                                            ->required()
                                            ->maxLength(255),
                                Forms\Components\FileUpload::make('images')
                                    ->label(__("Images"))
                                    ->image()
                                    ->disk('public')
                                    ->directory('places')
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->panelLayout('grid'),
                                ]),
                                Tabs\Tab::make(__("Location"))
                                ->schema([
                                    GoogleMapField::make('location')
                                    ->label(__("Location"))
                                    ->apiKey(env('GOOGLE_MAP_KEY'))
                                    ->reactive()
                                    ->afterStateUpdated(function (Forms\Set $set, $state) {
                                        $set('lng', $state->detail->lng);
                                        $set('lat', $state->detail->lat);
                                    })
                                    ->latField('lat')    // Bind to the 'lat' field
                                    ->lngField('lng'),
                                    Forms\Components\TextInput::make('lng')
                                        ->label(__('Longitude'))
                                        ->reactive()
                                        ->required(),
                                    Forms\Components\TextInput::make('lat')
                                        ->label(__('Latitude'))
                                        ->reactive()
                                        ->required(),
                            ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__("Address"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__("Creation Date"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPopularPlaces::route('/'),
            'create' => Pages\CreatePopularPlace::route('/create'),
            'edit' => Pages\EditPopularPlace::route('/{record}/edit'),
        ];
    }
}
