import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:persistent_bottom_nav_bar_v2/persistent_bottom_nav_bar_v2.dart';


class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {

  @override
  void initState() {
    super.initState();
  }


  @override
  Widget build(BuildContext context)
  {
    return Container(
      child: Column(
        children: [
          Container(
            width: 375.w,
            height: 300.h,
            color: Color(0xffC8CDE8),
            child: Center(
              child: Container(
                width: 200.w,
                height: 32.h,
                decoration: BoxDecoration(
                  image: DecorationImage(
                    image: AssetImage("assets/images/logo-black.png"),
                    fit: BoxFit.fill,
                  ),
                ),
              ),
            ),
          ),
          Expanded(
            child: Container(
              color: Color(0xFFF2F4FA),
              // child: ,
            ),
          ),
        ],
      ),
    );
  }
}
