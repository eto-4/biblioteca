<?php
/**
 * Interface Reservable
 *
 * Define el contrato para materiales que pueden ser reservados.
 * Solo las clases Llibre y DVD deben implementar esta interfaz; las Revistes no.
 *
 * Métodos:
 * - reservar(string $nomUsuari): bool
 *     Reserva el material para un usuario. Retorna false si ya está reservado.
 *
 * - cancelarReserva(): bool
 *     Cancela la reserva actual. Retorna false si no hay reserva.
 *
 * - estaReservat(): bool
 *     Comprueba si el material está reservado.
 *
 * - getUsuariReserva(): ?string
 *     Retorna el nombre del usuario que ha reservado el material, o null si no hay reserva.
 */
interface Reservable {
    public function reservar(string $nomUsuari): bool;
    public function cancelarReserva(): bool;
    public function estaReservat(): bool;
    public function getUsuariReserva(): ?string;
}
?>
