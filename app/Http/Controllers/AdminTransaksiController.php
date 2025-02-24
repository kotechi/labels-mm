<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_transaksi;

class AdminTransaksiController extends Controller
{

    public function edit(string $id_transaksi)
    {
        $transaksi = tbl_transaksi::find($id_transaksi);
        return view('admin.transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, string $id_transaksi)
    {
        $request->validate([
            'id_referens' => 'required',
            'pelaku_transaksi' => 'required',
            'keterangan' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
        ]);

        $transaksi = tbl_transaksi::find($id_transaksi);
        $transaksi->update($request->all());

        return redirect()->route('admin.index')
            ->with('success', 'Transaksi updated successfully');
    }

    public function destroy(string $id_transaksi)
    {
        $transaksi = tbl_transaksi::find($id_transaksi);
        $transaksi->delete();

        return redirect()->route('admin.index')
            ->with('success', 'Transaksi deleted successfully');
    }
}
