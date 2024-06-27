import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../blocs/authentication/authentication_bloc.dart';
import '../../blocs/authentication/authentication_event.dart';
import '../../blocs/authentication/authentication_state.dart';
import '../../lang/app_strings.dart';
import '../../repositories/authentication_repository.dart';
import '../../widgets/colors.dart';

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({super.key});

  @override
  _ProfileScreenState createState() => _ProfileScreenState();

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => const ProfileScreen());
  }
}

class _ProfileScreenState extends State<ProfileScreen> {
  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<AuthenticationBloc, AuthenticationState>(
      builder: (context, state) {
        if (state.status == AuthenticationStatus.authenticated) {
          return SizedBox(
            width: 375.w,
            height: 812.h,
            child: Stack(
              children: [
                topWidget(state),
                Positioned(
                  left: 0,
                  top: 272.h,
                  child: Container(
                    width: 375.w,
                    height: 532.h,
                    padding: const EdgeInsets.only(top: 30),
                    decoration: const ShapeDecoration(
                      color: AppColors.bgGrey,
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
                  top: 234.h,
                  child: Container(
                    width: 375.w,
                    height: 500.h,
                    padding: const EdgeInsets.only(left: 20, right: 20),
                    child: SingleChildScrollView(
                      child: Column(
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          const ProfileBody(),
                          SizedBox(height: 60.h),
                        ],
                      ),
                    ),
                  ),
                ),
              ],
            ),
          );
        } else {
          return Container();
        }
      },
    );
  }

  Widget topWidget(AuthenticationState state) {
    return Positioned(
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
              'assets/images/profile-bg.png',
            ),
            fit: BoxFit.cover,
          ),
        ),
        padding: EdgeInsets.only(top: 70.h),
        child: Column(
          children: [
            SizedBox(
              width: 335.w,
              // height: 63.h,
              child: Column(
                mainAxisSize: MainAxisSize.min,
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Container(
                    child: Row(
                      mainAxisSize: MainAxisSize.min,
                      mainAxisAlignment: MainAxisAlignment.start,
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: [
                        Text(
                          state.user.name,
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 12,
                            fontFamily: 'SF Pro Display',
                            fontWeight: FontWeight.w400,
                            height: 0,
                          ),
                        ),
                        const SizedBox(width: 10),
                        const Text(
                          '|  205号室',
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 12,
                            fontFamily: 'SF Pro Display',
                            fontWeight: FontWeight.w400,
                            height: 0,
                          ),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 5),
                  const Text.rich(
                    TextSpan(
                      children: [
                        TextSpan(
                          text: '`神奈川 太郎` ',
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 20,
                            fontFamily: 'SF Pro Display',
                            fontWeight: FontWeight.w700,
                            height: 0,
                          ),
                        ),
                        TextSpan(
                          text: AppStrings.sir,
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 14,
                            fontFamily: 'SF Pro Display',
                            fontWeight: FontWeight.w400,
                            height: 0,
                          ),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 5),
                  Text(
                    '${AppStrings.contractNumber}：${state.user.id}',
                    style: const TextStyle(
                      color: Colors.white,
                      fontSize: 12,
                      fontFamily: 'SF Pro Display',
                      fontWeight: FontWeight.w400,
                      height: 0,
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

class ProfileBody extends StatelessWidget {
  const ProfileBody({super.key});

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        SizedBox(
          width: 335.w,
          height: 110.h,
          child: Row(
            mainAxisSize: MainAxisSize.min,
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              profileBlock(label: AppStrings.myAccount, image: 'assets/images/avatar.png'),
              profileBlock(label: AppStrings.consultationHistory, image: 'assets/images/consultation.png'),
            ],
          ),
        ),
        SizedBox(height: 30.h),
        SizedBox(
          width: 335.w,
          child: const Text(
            AppStrings.setting,
            style: TextStyle(
              color: Color(0xFF101928),
              fontSize: 12,
              fontFamily: 'SF Pro Display',
              fontWeight: FontWeight.w700,
            ),
          ),
        ),
        SizedBox(height: 10.h),
        profileRow(label: AppStrings.serviceTerms),
        profileRow(label: AppStrings.privacyPolicy),
        profileRow(label: AppStrings.company),
        logoutButton(context),
        footer(),
        SizedBox(height: 30.h),
      ],
    );
  }

  Widget logoutButton(BuildContext context) {
    return InkWell(
        onTap: (){
          context
              .read<AuthenticationBloc>()
              .add(AuthenticationLogoutRequested());
        },
        child: Container(
          margin: EdgeInsets.only(bottom: 10.h),
          width: 335.w,
          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 14),
          clipBehavior: Clip.antiAlias,
          decoration: ShapeDecoration(
            color: Colors.white,
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
          ),
          child: const Row(
            mainAxisSize: MainAxisSize.min,
            mainAxisAlignment: MainAxisAlignment.start,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              Expanded(
                child: Text(
                  AppStrings.logout,
                  style: TextStyle(
                    color: Colors.red,
                    fontSize: 14,
                    fontFamily: 'SF Pro Display',
                    fontWeight: FontWeight.w400,
                    height: 0,
                  ),
                ),
              ),
            ],
          ),
        ),
      );
  }

  Container footer() {
    return Container(
        width: 335.w,
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 14),
        clipBehavior: Clip.antiAlias,
        decoration: ShapeDecoration(
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
          shadows: [
            const BoxShadow(
              color: Color(0x0A000000),
              blurRadius: 48,
              offset: Offset(0, 2),
              spreadRadius: 0,
            )
          ],
        ),
        child: const Row(
          mainAxisSize: MainAxisSize.min,
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            Text(
              AppStrings.version,
              textAlign: TextAlign.center,
              style: TextStyle(
                color: Color(0xFF667185),
                fontSize: 12,
                fontFamily: 'SF Pro Display',
                fontWeight: FontWeight.w400,
                height: 0,
              ),
            ),
            SizedBox(width: 10),
            Text(
              '1.0.1',
              textAlign: TextAlign.center,
              style: TextStyle(
                color: Color(0xFF667185),
                fontSize: 12,
                fontFamily: 'SF Pro Display',
                fontWeight: FontWeight.w400,
                height: 0,
              ),
            ),
          ],
        ),
      );
  }

  Widget profileRow({required String label}) {
    return Container(
      margin: EdgeInsets.only(bottom: 10.h),
      width: 335.w,
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 14),
      clipBehavior: Clip.antiAlias,
      decoration: ShapeDecoration(
        color: Colors.white,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        mainAxisAlignment: MainAxisAlignment.start,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Expanded(
            child: Text(
              label,
              style: const TextStyle(
                color: AppColors.textDart,
                fontSize: 14,
                fontFamily: 'SF Pro Display',
                fontWeight: FontWeight.w400,
                height: 0,
              ),
            ),
          ),
          const SizedBox(width: 10),
          const Icon(
            Icons.arrow_forward_ios_outlined,
            color: AppColors.textGrey,
          ),
        ],
      ),
    );
  }


  Widget profileBlock({required String label, required String image}) {
    return Container(
      width: 158.w,
      height: 110.w,
      padding: const EdgeInsets.only(
        top: 0,
        left: 15,
        right: 15,
        bottom: 0,
      ),
      clipBehavior: Clip.antiAlias,
      decoration: ShapeDecoration(
        color: AppColors.primaryColor,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12),
        ),
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Container(
            height: 50.h,
            padding:
                const EdgeInsets.only(top: 1, left: 3, right: 4, bottom: 1),
            clipBehavior: Clip.antiAlias,
            decoration: const BoxDecoration(),
            child: Image.asset(
              image
            ),
          ),
          Text(
            label,
            style: const TextStyle(
              color: AppColors.textWhite,
              fontSize: 14,
              fontFamily: 'SF Pro Display',
              fontWeight: FontWeight.w700,
            ),
          ),
        ],
      ),
    );
  }
}
