@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card">
            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                <img src="{{ $product['image'] }}" class="img-fluid mb-3" alt="{{ $product['name'] }}">
                <p>Anda akan melakukan pembelian produk <strong>{{ $product['name'] }}</strong> dengan harga <strong>Rp{{ number_format($product['price'], 0, ',', '.') }}</strong></p>
                <div class="d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn btn-success mt-3 me-3" id="pay-button">
                            Bayar Sekarang
                        </button>
                    </div>
                    <div>
                        <form action="{{ route('transactions') }}" method="GET">
                            <button type="submit" class="btn btn-primary mt-3">Lihat Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env("MIDTRANS_CLIENT_KEY") }}"></script>
<script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $transaction->snap_token }}', {
          onSuccess: function(result){
            window.location.href = '{{ route('checkout-success', $transaction->id) }}'
          },
          onPending: function(result){
            document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          },
          onError: function(result){
            document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          }
        });
      };
</script>
@endsection
