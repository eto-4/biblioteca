<?php
/**
 * Interface Reservable
 *
 * Defineix el contracte per a materials que poden ser reservats.
 * Només les classes Llibre i DVD han d'implementar aquesta interfície; les Revistes no.
 *
 * Mètodes:
 * - reservar(string $nomUsuari): bool
 *     Reserva el material per a un usuari. Retorna false si ja està reservat.
 *
 * - cancelarReserva(): bool
 *     Cancel·la la reserva actual. Retorna false si no hi ha reserva.
 *
 * - estaReservat(): bool
 *     Comprova si el material està reservat.
 *
 * - getUsuariReserva(): ?string
 *     Retorna el nom de l'usuari que ha reservat el material, o null si no hi ha reserva.
 */
interface Reservable {
    /**
     * Reserva el material per a un usuari.
     *
     * @param string $nomUsuari Nom de l'usuari que vol reservar el material.
     * @return bool True si la reserva s'ha realitzat correctament, false si ja estava reservat.
     */
    public function reservar(string $nomUsuari): bool;

    /**
     * Cancel·la la reserva actual del material.
     *
     * @return bool True si la reserva s'ha cancel·lat correctament, false si no hi havia reserva.
     */
    public function cancelarReserva(): bool;

    /**
     * Comprova si el material està actualment reservat.
     *
     * @return bool True si hi ha una reserva activa, false si no.
     */
    public function estaReservat(): bool;

    /**
     * Obté el nom de l'usuari que ha reservat el material.
     *
     * @return string|null Nom de l'usuari que ha fet la reserva, o null si no hi ha reserva.
     */
    public function getUsuariReserva(): ?string;
}
?>
