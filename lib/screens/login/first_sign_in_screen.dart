import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:logmansion_app/screens/login/sign_in_email_screen.dart';
import '../../widgets/colors.dart';

class FirstSignInScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _buildBody(context),
    );
  }

  Widget _buildBody(BuildContext context){
    return  Container(
      width: 375.w,
      height: 812.h,
      clipBehavior: Clip.antiAlias,
      decoration: BoxDecoration(color: AppColors.primaryColor),
      child: Stack(
        children: [
          Positioned(
            left: 30.w,
            top: 455.w,
            child: Container(child: Stack()),
          ),
          Positioned(
            left: 87.w,
            top: 100.h,
            child: Container(
              width: 200.w,
              height: 27.62.h,
              decoration: BoxDecoration(
                image: DecorationImage(
                  image: AssetImage("assets/images/logo.png"),
                  fit: BoxFit.fill,
                ),
              ),
            ),
          ),
          Positioned(
            left: 27.w,
            top: 160.h,
            child: Container(
              child: Column(
                mainAxisSize: MainAxisSize.min,
                mainAxisAlignment: MainAxisAlignment.start,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  SizedBox(
                    width: 319.w,
                    height: 52.h,
                    child: Text(
                      'お客様番号を入力してください。',
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        color: AppColors.textWhite,
                        fontSize: 16,
                        fontFamily: 'SF Pro Display',
                        fontWeight: FontWeight.w400,
                        height: 0.10,
                      ),
                    ),
                  ),
                  const SizedBox(height: 30),
                  Container(
                    width: 300.w,
                    height: 214.h,
                    child: Stack(
                      children: [
                        Positioned(
                          left: 0,
                          top: 170.h,
                          child: SizedBox(
                            width: 300.w,
                            child: Text(
                              '契約時に発行された10桁のお客様番号を\n入力してください。',
                              textAlign: TextAlign.center,
                              style: TextStyle(
                                color: AppColors.textWhite,
                                fontSize: 14,
                                fontFamily: 'SF Pro Display',
                                fontWeight: FontWeight.w400,
                                height: 0.11,
                              ),
                            ),
                          ),
                        ),
                        Positioned(
                          left: 90.w,
                          top: 0,
                          child: Container(
                            width: 120,
                            height: 150,
                            decoration: ShapeDecoration(
                              color: Colors.white,
                              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
                            ),
                          ),
                        ),
                        Positioned(
                          left: 104.w,
                          top: 39.h,
                          child: Container(
                            width: 91.w,
                            height: 29.h,
                            decoration: ShapeDecoration(
                              shape: RoundedRectangleBorder(
                                side: BorderSide(width: 4, color: Color(0xFFEB5757)),
                              ),
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                  SizedBox(height: 30.h),
                  Container(
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      mainAxisAlignment: MainAxisAlignment.start,
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          'お客様番号',
                          style: TextStyle(
                            color: AppColors.textWhite,
                            fontSize: 14,
                            fontFamily: 'SF Pro Display',
                            fontWeight: FontWeight.w700,
                            height: 0,
                          ),
                        ),
                        const SizedBox(height: 10),
                        Container(
                          width: 320.w,
                          height: 45.h,
                          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 14),
                          decoration: ShapeDecoration(
                            color: Colors.white,
                            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(5)),
                          ),
                          child: Row(
                            mainAxisSize: MainAxisSize.min,
                            mainAxisAlignment: MainAxisAlignment.start,
                            crossAxisAlignment: CrossAxisAlignment.center,
                            children: [
                              Text(
                                '半角英数でご入力ください',
                                style: TextStyle(
                                  color: Color(0xFF828282),
                                  fontSize: 12,
                                  fontFamily: 'Plus Jakarta Sans',
                                  fontWeight: FontWeight.w400,
                                  height: 0,
                                  letterSpacing: 0.24,
                                ),
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                  SizedBox(height: 30.h),
                  InkWell(
                    onTap: () {
                      Navigator.push(
                          context,
                          MaterialPageRoute(builder: (context)=> SignInEmailScreen()),
                      );
                    },
                    child: Container(
                      width: 320.w,
                      padding: const EdgeInsets.all(15),
                      decoration: ShapeDecoration(
                        color: AppColors.buttonColor,
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
                      ),
                      child: Row(
                        mainAxisSize: MainAxisSize.min,
                        mainAxisAlignment: MainAxisAlignment.center,
                        crossAxisAlignment: CrossAxisAlignment.center,
                        children: [
                          Text(
                            '次へ',
                            style: TextStyle(
                              color: AppColors.textWhite,
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
          ),
        ],
      ),
    );
  }
}