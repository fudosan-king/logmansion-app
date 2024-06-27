import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../blocs/authentication/authentication_bloc.dart';
import '../../blocs/authentication/authentication_event.dart';
import '../../models/schedule.dart';
import '../../widgets/colors.dart';
import '../catalog/catalog_screen.dart';
import 'widgets/menu_list.dart';
import 'widgets/schedule_widget.dart';
import 'widgets/welcome_field.dart';

class HomeScreen extends StatefulWidget {
  HomeScreen({super.key});

  @override
  _HomeScreenState createState() => _HomeScreenState();

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => HomeScreen());
  }
}

class _HomeScreenState extends State<HomeScreen> {
  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    final userName = context.select((AuthenticationBloc bloc) => bloc.state.user.name);
    return SizedBox(
      width: 375.w,
      height: 812.h,
      child: Stack(
        children: [
          Positioned(
            left: 0,
            top: 0,
            right: 0,
            child: Container(
              width: 375.w,
              height: 310.h,
              decoration: const BoxDecoration(
                color: Color(0xffC8CDE8),
                image: DecorationImage(
                  image: AssetImage(
                    'assets/images/home-bg.png',
                  ),
                  fit: BoxFit.cover,
                ),
              ),
              padding: EdgeInsets.only(top: 110.h),
              child: Center(
                child: Container(
                  width: 222.w,
                  height: 60.h,
                  child: Column(
                      mainAxisSize: MainAxisSize.min,
                      mainAxisAlignment: MainAxisAlignment.start,
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: [
                        Container(
                          width: 222.w,
                          height: 30.h,
                          clipBehavior: Clip.antiAlias,
                          decoration: const BoxDecoration(),
                          child: Image.asset("assets/images/logo.png"),
                        ),
                        SizedBox(height: 10.h),
                        const Text(
                          'OWNERS CLUB',
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 14,
                            fontFamily: 'Didact Gothic',
                            fontWeight: FontWeight.w400,
                            height: 0,
                            letterSpacing: 2,
                          ),
                        ),
                      ]),
                ),
              ),
            ),
          ),
          Positioned(
            left: 0,
            top: 270.h,
            child: Container(
              width: 375.w,
              height: 542.h,
              // color: const Color(0xFFF2F4FA),
              padding: const EdgeInsets.only(top: 30),
              decoration: const ShapeDecoration(
                color: AppColors.primaryColor,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.only(
                    topLeft: Radius.circular(24),
                    topRight: Radius.circular(24),
                  ),
                ),
              ),
            ),
          ),
          Positioned(
            left: 0,
            top: 250.h,
            child: Container(
              width: 375.w,
              // height: 500.h,
              padding: const EdgeInsets.only(left: 20, right: 20),
              child: SingleChildScrollView(
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    const ScheduleWidget(),
                    WelcomeField(name: userName),
                    SizedBox(height: 18.h),
                    const Menu(),
                    SizedBox(height: 60.h),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}

