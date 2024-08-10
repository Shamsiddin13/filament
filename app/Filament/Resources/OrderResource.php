<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
// use DeepCopy\Filter\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ID_number')->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('createdAt')->label('Buyurtma sanasi')->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('displayProductName')->label('Mahsulot')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('article')->label('Artikul')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')->label('Holat')
                    ->badge()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'В пути' => 'info',
                            'Возврат' => 'warning',
                            'Выполнен' => 'success',
                            'Доставлен' => 'success',
                            'Недозвон' => 'primary',
                            'Новый' => 'primary',
                            'Отмена' => 'danger',
                            'Подмены' => 'primary',
                            'Принят' => 'primary'
                        };
                    })
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('statusUpdatedAt')->label("O'hirgi o'zgarish")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('source')->label('Source')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('target')->label('Target')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->searchable()
                    ->multiple()
                    ->options([
                        'В пути' => 'В пути',
                        'Возврат' => 'Возврат',
                        'Выполнен' => 'Выполнен',
                        'Доставлен' => 'Доставлен',
                        'Недозвон' => 'Недозвон',
                        'Новый' => 'Новый',
                        'Отмена' => 'Отмена',
                        'Подмены' => 'Подмены',
                        'Принят' => 'Принят',
                    ])
                    ->label('Status'),
                Filter::make('createdAt')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('createdAt', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('createdAt', '<=', $date),
                            );
                    })
            ])
            ->filtersFormColumns(2)
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
