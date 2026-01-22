<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related model
     */
    public function subject()
    {
        if ($this->model_type && $this->model_id) {
            return $this->model_type::find($this->model_id);
        }
        return null;
    }

    /**
     * Log an activity
     * 
     * @param string $action The action being logged
     * @param Model|string|null $subject The model being acted upon or a description string
     * @param array|null $oldValues Previous values (for updates)
     * @param array|null $newValues New values (for updates)
     */
    public static function log(
        string $action,
        Model|string|null $subject = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): self {
        $modelType = null;
        $modelId = null;
        $description = null;

        if ($subject instanceof Model) {
            $modelType = get_class($subject);
            $modelId = $subject->getKey();
            // Generate automatic description based on model
            $modelName = class_basename($modelType);
            $description = "{$action} - {$modelName} #{$modelId}";
        } elseif (is_string($subject)) {
            $description = $subject;
        } else {
            // Default description if no subject provided
            $description = $action;
        }

        return static::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => substr(request()->userAgent() ?? '', 0, 500),
        ]);
    }

    /**
     * Get action label in Spanish
     */
    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'login' => 'Inicio de sesión',
            'logout' => 'Cierre de sesión',
            'register' => 'Registro de usuario',
            'password_reset' => 'Restablecimiento de contraseña',
            'profile_updated' => 'Perfil actualizado',
            'order_created' => 'Pedido creado',
            'order_updated' => 'Pedido actualizado',
            'order_cancelled' => 'Pedido cancelado',
            'product_created' => 'Producto creado',
            'product_updated' => 'Producto actualizado',
            'product_deleted' => 'Producto eliminado',
            'category_created' => 'Categoría creada',
            'category_updated' => 'Categoría actualizada',
            'category_deleted' => 'Categoría eliminada',
            'user_created' => 'Usuario creado',
            'user_updated' => 'Usuario actualizado',
            'user_deleted' => 'Usuario eliminado',
            'review_created' => 'Reseña creada',
            'review_deleted' => 'Reseña eliminada',
            default => ucfirst(str_replace('_', ' ', $this->action)),
        };
    }

    /**
     * Get action icon
     */
    public function getActionIconAttribute(): string
    {
        return match($this->action) {
            'login' => 'bi-box-arrow-in-right',
            'logout' => 'bi-box-arrow-right',
            'register' => 'bi-person-plus',
            'password_reset' => 'bi-key',
            'profile_updated' => 'bi-person-gear',
            'order_created', 'order_updated' => 'bi-bag',
            'order_cancelled' => 'bi-bag-x',
            'product_created', 'product_updated' => 'bi-box-seam',
            'product_deleted' => 'bi-trash',
            'category_created', 'category_updated', 'category_deleted' => 'bi-tags',
            'user_created', 'user_updated', 'user_deleted' => 'bi-people',
            'review_created', 'review_deleted' => 'bi-star',
            default => 'bi-activity',
        };
    }
}
