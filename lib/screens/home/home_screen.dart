import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:persistent_bottom_nav_bar_v2/persistent_bottom_nav_bar_v2.dart';

import '../../blocs/authentication/authentication_bloc.dart';
import '../../blocs/authentication/authentication_event.dart';
import '../../models/schedule.dart';
import '../../widgets/colors.dart';

class HomeScreen extends StatefulWidget {
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
    return Container(
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
                  height: 58.h,
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
                        const SizedBox(height: 10),
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
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  // Builder(
                  //   builder: (context) {
                  //     final userId = context.select(
                  //       (AuthenticationBloc bloc) => bloc.state.user.id,
                  //     );
                  //     return Text('UserID: $userId');
                  //   },
                  // ),
                  // ElevatedButton(
                  //   child: const Text('Logout'),
                  //   onPressed: () {
                  //     context
                  //         .read<AuthenticationBloc>()
                  //         .add(AuthenticationLogoutRequested());
                  //   },
                  // ),
                ],
              ),
            ),
          ),
          Positioned(
            left: 0,
            top: 250.h,
            child: Container(
              width: 375.w,
              height: 500.h,
              padding: const EdgeInsets.only(left: 20, right: 20),
              child: SingleChildScrollView(
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    ScheduleWidget(),
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

class ScheduleWidget extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    List<Schedule> schedules = [];
    return Column(
      mainAxisSize: MainAxisSize.min,
      mainAxisAlignment: MainAxisAlignment.start,
      crossAxisAlignment: CrossAxisAlignment.center,
      children: [
        Container(
          width: 335.w,
          clipBehavior: Clip.antiAlias,
          decoration: BoxDecoration(),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            mainAxisAlignment: MainAxisAlignment.start,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Expanded(
              //   child: ListView.builder(
              //       itemCount: schedules.length,
              //       itemBuilder: (BuildContext context, int index) {
              //     return ScheduleItem(schedule: schedules[index]);
              //   }),
              // ),
              // ScheduleItem(schedule),
              const SizedBox(height: 6),
              Center(
                child: Icon(Icons.keyboard_arrow_down_outlined, color: AppColors.buttonColor),
              ),
            ],
          ),
        ),
      ],
    );
  }
}

class ScheduleItem extends StatelessWidget {
  const ScheduleItem({
    super.key,
    required this.schedule,
  });

  final Schedule schedule;

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 47.h,
      padding: EdgeInsets.all(12.w),
      margin: EdgeInsets.only(bottom: 6.h),
      clipBehavior: Clip.antiAlias,
      decoration: ShapeDecoration(
        color: Colors.white,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Expanded(
            child: Container(
              height: 17.h,
              child: Row(
                mainAxisSize: MainAxisSize.min,
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  Container(
                    width: 18.w,
                    height: 18.w,
                    clipBehavior: Clip.antiAlias,
                    decoration: const BoxDecoration(),
                    child: Image.asset("assets/images/icon_atention.png", width: 18.w),
                  ),
                  SizedBox(width: 6.w),
                  Expanded(
                    child: Container(
                      child: Text(
                        schedule.name,
                        // textAlign: TextAlign.center,
                        overflow: TextOverflow.visible,
                        maxLines: 1,
                        style: TextStyle(
                          color: Color(0xFF101928),
                          fontSize: 14,
                          fontFamily: 'SF Pro Display',
                          fontWeight: FontWeight.w700,
                          height: 0.08,
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(width: 6),
                  Container(
                    child: Row(
                      mainAxisSize: MainAxisSize.min,
                      mainAxisAlignment: MainAxisAlignment.end,
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: [
                        Text(
                          schedule.date,
                          textAlign: TextAlign.right,
                          maxLines: 1,
                          style: TextStyle(
                            color: AppColors.textGrey500,
                            fontSize: 14,
                            fontFamily: 'SF Pro Display',
                            fontWeight: FontWeight.w700,
                            height: 0.08,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(width: 16),
          Container(
            width: 16.w,
            height: 16.w,
            clipBehavior: Clip.antiAlias,
            decoration: const BoxDecoration(),
            child: Icon(Icons.arrow_forward_ios_outlined,size: 16.w, color: AppColors.textGrey500),
          ),
        ],
      ),
    );
  }
}
