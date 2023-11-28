import 'package:client/components/user_cart_item.dart';
import 'package:client/providers/user_cart.dart';
import 'package:client/screens/user/widgets/cart/checkout_screen.dart';
import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

class CartScreen extends ConsumerStatefulWidget {
  const CartScreen({super.key});

  @override
  ConsumerState<CartScreen> createState() => _CartScreenState();
}

class _CartScreenState extends ConsumerState<CartScreen> {
  @override
  Widget build(BuildContext context) {
    final carts = ref.watch(userCartProvider);

    if (carts == null) {
      return const IconButton(onPressed: null, icon: Icon(Icons.shopping_cart));
    }

    void openCartScreen() {
      void checkout() {
        Navigator.pop(context);
        Navigator.push(context, PageRouteBuilder(pageBuilder: (_, __, ___) {
          return const CheckoutScreen();
        }));
      }

      showDialog(
        context: context,
        builder: (context) {
          return Scaffold(
            appBar: AppBar(
              title: const Text('Cart'),
            ),
            bottomNavigationBar: Container(
              height: 80,
              padding: const EdgeInsets.symmetric(horizontal: 16),
              decoration: BoxDecoration(
                color: Theme.of(context)
                    .colorScheme
                    .primaryContainer
                    .withOpacity(.5),
              ),
              child: Row(
                children: [
                  Text(
                    'Total: \$${carts.total}',
                    style: Theme.of(context).textTheme.bodyLarge,
                  ),
                  const Spacer(),
                  ElevatedButton(
                    onPressed: carts.detailTransactions == null ||
                            carts.detailTransactions!.isEmpty
                        ? null
                        : checkout,
                    child: const Text('Checkout'),
                  ),
                ],
              ),
            ),
            body: Container(
              padding: const EdgeInsets.all(12),
              child: ListView(
                children: [
                  // loop carts detail transactions
                  if (carts.detailTransactions != null &&
                      carts.detailTransactions!.isNotEmpty)
                    for (final cart in carts.detailTransactions!)
                      UserCartItem(
                        detailTransaction: cart,
                        key: ValueKey(cart.id),
                      ),
                ],
              ),
            ),
          );
        },
      );
    }

    return IconButton(
      onPressed: openCartScreen,
      icon: Badge(
        label: Text(carts.detailTransactions!.length.toString()),
        child: const Icon(Icons.shopping_cart),
      ),
    );
  }
}
