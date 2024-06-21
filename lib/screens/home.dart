import 'package:flutter/material.dart';
import 'package:logmansion_app/screens/profile/home_screen.dart';
import 'package:persistent_bottom_nav_bar_v2/persistent_bottom_nav_bar_v2.dart';

import '../lang/app_strings.dart';
import '../widgets/colors.dart';
import 'home/home_screen.dart';

class Home extends StatefulWidget {
  @override
  _HomeState createState() => _HomeState();

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => Home());
  }
}

class _HomeState extends State<Home> {
  late PersistentTabController _controller;

  @override
  void initState() {
    super.initState();
    _controller = PersistentTabController(initialIndex: 0);
  }

  List<PersistentTabConfig> _navBarsItems() {
    return [
      PersistentTabConfig(
        screen: HomeScreen(),
        item: ItemConfig(
          icon: Icon(Icons.home),
          title: AppStrings.home,
          activeForegroundColor: AppColors.buttonColor,
          inactiveForegroundColor: Colors.white,
        ),
      ),
      PersistentTabConfig(
        screen: HomeScreen(),
        item: ItemConfig(
          icon: Icon(Icons.notifications),
          title: AppStrings.notification,
          activeForegroundColor: AppColors.buttonColor,
          inactiveForegroundColor: Colors.white,
        ),
      ),
      PersistentTabConfig(
        screen: HomeScreen(),
        item: ItemConfig(
          icon: Icon(Icons.mail_rounded, color: Colors.black),
          title: AppStrings.message,
          activeForegroundColor: Colors.white,
          inactiveForegroundColor: Colors.white,
        ),
      ),
      PersistentTabConfig(
        screen: HomeScreen(),
        item: ItemConfig(
          icon: Icon(Icons.file_copy),
          title: AppStrings.document,
          activeForegroundColor: AppColors.buttonColor,
          inactiveForegroundColor: Colors.white,
        ),
      ),
      PersistentTabConfig(
        screen: ProfileScreen(),
        item: ItemConfig(
          icon: Icon(Icons.person),
          title: AppStrings.profile,
          activeForegroundColor: AppColors.buttonColor,
          inactiveForegroundColor: Colors.white,
        ),
      ),
    ];
  }

  @override
  Widget build(BuildContext context) {
    return PersistentTabView(
      controller: _controller,
      backgroundColor: Colors.red,
      tabs: _navBarsItems(),
      handleAndroidBackButtonPress: true,
      resizeToAvoidBottomInset: true,
      stateManagement: true,
      navBarBuilder: (navBarConfig) => Style13BottomNavBar(
        navBarConfig: navBarConfig,
        navBarDecoration: NavBarDecoration(
          color: AppColors.primaryBlack,
          borderRadius: BorderRadius.only(
            topLeft: Radius.circular(20.0),
            topRight: Radius.circular(20.0),
          ),
        ),
      ),
    );
  }
}
