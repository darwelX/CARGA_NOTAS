<?php
interface Operaciones {
	public function find($id);
	public function findBy($condicion);
	public function insert();
	public function update();
}