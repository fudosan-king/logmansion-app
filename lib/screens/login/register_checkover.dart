import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../blocs/authentication/authentication_event.dart';
import '../../blocs/authentication/authentication_state.dart';
import '../../lang/app_strings.dart';
import '../../repositories/authentication_repository.dart';
import '../../widgets/component.dart';
import '../home/home_screen.dart';
import '../../widgets/colors.dart';
import '/blocs/authentication/authentication_bloc.dart';
import '/utils/validators.dart';

class RegisterCheckOverScreen extends StatefulWidget {
  const RegisterCheckOverScreen({super.key});

  @override
  State<RegisterCheckOverScreen> createState() => _RegisterCheckOverScreenState();

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => const RegisterCheckOverScreen());
  }
}

class _RegisterCheckOverScreenState extends State<RegisterCheckOverScreen> {

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _buildBody(context),
    );
  }

  Widget _buildBody(BuildContext context) {
    return Container(
      width: 375.w,
      height: 812.h,
      padding: EdgeInsets.only(
        top: 100.h,
        left: 28.w,
        right: 28.w,
      ),
      clipBehavior: Clip.antiAlias,
      decoration: const BoxDecoration(color: AppColors.primaryColor),
      child: SingleChildScrollView(
        child: Column(
          mainAxisSize: MainAxisSize.min,
          mainAxisAlignment: MainAxisAlignment.start,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            SizedBox(
              width: 320.w,
              child: Text(
                AppStrings.register,
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: AppColors.textWhite,
                  fontSize: 24.sp,
                  fontFamily: 'SF Pro Display',
                  fontWeight: FontWeight.w800,
                  height: 1.0,
                  letterSpacing: 1.20.sp,
                ),
              ),
            ),
            SizedBox(height: 31.h),
            Container(
              width: double.infinity,
              child: Column(
                mainAxisSize: MainAxisSize.min,
                mainAxisAlignment: MainAxisAlignment.start,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  SizedBox(height: 20.h),
                  SizedBox(
                    width: 319.w,
                    height: 52.h,
                    child: Text(
                      AppStrings.messageRegister,
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        color: Color(0xFFB49554),
                        fontSize: 16,
                        fontFamily: 'SF Pro Display',
                        fontWeight: FontWeight.w700,
                      ),
                    ),
                  ),
                  SizedBox(height: 20.h),
                  SizedBox(
                    width: 319.w,
                    child: Text(
                      AppStrings.notificationRegister,
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        color: AppColors.textGrey,
                        fontSize: 16.sp,
                        fontFamily: 'SF Pro Display',
                        fontWeight: FontWeight.w400,
                        height: 1.5,
                      ),
                    ),
                  ),
                  SizedBox(height: 30.h),
                  InkWell(
                    onTap: () {
                      // Navigator.push(context, MaterialPageRoute(builder: (context) => HomeScreen()));
                      context.read<AuthenticationBloc>().add(
                          const AuthenticationStatusChanged(
                              AuthenticationStatus.authenticated));
                    },
                    child: Container(
                      width: 320.w,
                      padding: const EdgeInsets.all(15),
                      decoration: ShapeDecoration(
                        color: AppColors.buttonColor,
                        shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(6)),
                      ),
                      child: const Row(
                        mainAxisSize: MainAxisSize.min,
                        mainAxisAlignment: MainAxisAlignment.center,
                        crossAxisAlignment: CrossAxisAlignment.center,
                        children: [
                          Text(
                            AppStrings.proceedToLogin,
                            style: TextStyle(
                              color: Colors.white,
                              fontSize: 16,
                              fontFamily: 'SF Pro Display',
                              fontWeight: FontWeight.w700,
                              height: 0,
                              letterSpacing: 0.32,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
