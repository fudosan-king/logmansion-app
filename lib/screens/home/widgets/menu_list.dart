import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../catalog/catalog_screen.dart';
import 'menu_item.dart';

class Menu extends StatelessWidget {
  const Menu({super.key});

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: 335.w,
      // height: 210.h,
      child: Wrap(
        spacing: 9.w,
        runSpacing: 10,
        children: [
          MenuItem(title: 'マイページ', image: 'assets/images/menu-icon1.png',),
          MenuItem(title: 'お問合わせ', image: 'assets/images/menu-icon2.png'),
          MenuItem(title: '契約書類', image: 'assets/images/menu-icon3.png'),
          MenuItem(title: 'オーダー家具', image: 'assets/images/menu-icon4.png',
              onTap: () {
                Navigator.of(context).push<void>(
                  CatalogScreen.route(),
                );
              }),
          MenuItem(title: 'お役立ち情報', image: 'assets/images/menu-icon5.png'),
          MenuItem(title: 'よくある質問', image: 'assets/images/menu-icon6.png'),
        ],
      ),
    );
  }
}