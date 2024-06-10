import 'package:flutter/material.dart';
import 'package:persistent_bottom_nav_bar_v2/persistent_bottom_nav_bar_v2.dart';

import 'home/home_screen.dart';


class Home extends StatefulWidget {
  @override
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {
  late PersistentTabController _controller;

  @override
  void initState() {
    super.initState();
    _controller = PersistentTabController(initialIndex: 0);
  }

  List<Widget> _buildScreens() {
    return [
      Center(child: Text("Home")),
      Center(child: Text("Notifications")),
      Center(child: Text("Message")),
      Center(child: Text("File")),
      Center(child: Text("Profile")),
    ];
  }

  List<PersistentTabConfig> _navBarsItems() {
    return [
      PersistentTabConfig(
        screen: HomeScreen(),
        item: ItemConfig(
          icon: Icon(Icons.home),
          title: "Home",
          activeForegroundColor: Color(0xFF4B57B1),
          inactiveForegroundColor: Colors.grey,
        ),
      ),
      PersistentTabConfig(
        screen: HomeScreen(),
        item: ItemConfig(
          icon: Icon(Icons.notifications),
          title: "Notifications",
          activeForegroundColor: Color(0xFF4B57B1),
          inactiveForegroundColor: Colors.grey,
        ),
      ),
      PersistentTabConfig(
        screen: HomeScreen(),
        item: ItemConfig(
          icon: Icon(Icons.mail),
          title: "Message",
          activeForegroundColor: Color(0xFF4B57B1),
          inactiveForegroundColor: Colors.white,
        ),
      ),
      PersistentTabConfig(
        screen: HomeScreen(),
        item: ItemConfig(
          icon: Icon(Icons.file_copy),
          title: "File",
          activeForegroundColor: Color(0xFF4B57B1),
          inactiveForegroundColor: Colors.grey,
        ),
      ),
      PersistentTabConfig(
        screen: HomeScreen(),
        item: ItemConfig(
          icon: Icon(Icons.person),
          title: "Profile",
          activeForegroundColor: Color(0xFF4B57B1),
          inactiveForegroundColor: Colors.grey,
        ),
      ),
    ];
  }

  @override
  Widget build(BuildContext context) {
    return PersistentTabView(
      controller: _controller,
      tabs: _navBarsItems(),
      navBarBuilder: (navBarConfig) => Style13BottomNavBar(
        navBarConfig: navBarConfig,
      ),
    );
  }
}
