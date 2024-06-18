import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:formz/formz.dart';
import '../../blocs/login/login_bloc.dart';
import '../../blocs/login/login_event.dart';
import '../../blocs/login/login_state.dart';
import '../../repositories/authentication_repository.dart';
import '../../widgets/popup.dart';
import '../../widgets/colors.dart';
import '../../lang/app_strings.dart';
import '../../widgets/component.dart';

class SignInScreen extends StatefulWidget {
  const SignInScreen({super.key});

  @override
  State<SignInScreen> createState() => _SignInScreenState();

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => const SignInScreen());
  }
}

class _SignInScreenState extends State<SignInScreen> {
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: BlocProvider(
        create: (context) => LoginBloc(
          authenticationRepository:
              RepositoryProvider.of<AuthenticationRepository>(context),
        ),
        child: _buildBody(context),
      ),
    );
  }

  Widget _buildBody(BuildContext context) {
    return Container(
      width: 375.w,
      height: 812.h,
      clipBehavior: Clip.antiAlias,
      decoration: const BoxDecoration(color: AppColors.primaryColor),
      padding: EdgeInsets.only(
        top: 100.h,
        left: 28.w,
        right: 28.w,
      ),
      child: SingleChildScrollView(
        child: Column(
          children: [
            Container(
              width: 200.w,
              height: 27.62.h,
              decoration: const BoxDecoration(
                image: DecorationImage(
                  image: AssetImage("assets/images/logo.png"),
                  fit: BoxFit.fill,
                ),
              ),
            ),
            LoginForm(
                emailController: _emailController,
                passwordController: _passwordController),
          ],
        ),
      ),
    );
  }
}

class LoginForm extends StatelessWidget {
  const LoginForm({
    super.key,
    required TextEditingController emailController,
    required TextEditingController passwordController,
  })  : _emailController = emailController,
        _passwordController = passwordController;

  final TextEditingController _emailController;
  final TextEditingController _passwordController;

  @override
  Widget build(BuildContext context) {
    return BlocListener<LoginBloc, LoginState>(
      listener: (context, state) {
        if (state.status.isFailure) {
          // ScaffoldMessenger.of(context)
          //   ..hideCurrentSnackBar()
          //   ..showSnackBar(
          //     const SnackBar(content: Text('Authentication Failure')),
          //   );
          String title = r'半角英大文字小文字と数字の組み合わせに問題があるか使えない文字が入力されました';
          String content = r'お客様番号をお確かめの上再度入力してください';
          CustomDialog.alertDialog(
              context: context, title: title, content: content);
        }
      },
      child: BlocBuilder<LoginBloc, LoginState>(
        builder: (context, state) {
          return Container(
            child: Column(
              mainAxisSize: MainAxisSize.min,
              mainAxisAlignment: MainAxisAlignment.start,
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                SizedBox(height: 30.h),
                SizedBox(
                  width: 319.w,
                  height: 52.h,
                  child: const Text(
                    AppStrings.validateLogin,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: AppColors.textGrey,
                      fontSize: 16,
                      fontFamily: 'SF Pro Display',
                      fontWeight: FontWeight.w400,
                      height: 1.5,
                    ),
                  ),
                ),
                SizedBox(height: 30.h),
                Container(
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    mainAxisAlignment: MainAxisAlignment.start,
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      CustomTextField(
                        label: AppStrings.clientID,
                        hint: AppStrings.hintClientID,
                        controller: _emailController,
                        onChanged: (username) => context
                            .read<LoginBloc>()
                            .add(LoginUsernameChanged(username)),
                      ),
                    ],
                  ),
                ),
                SizedBox(height: 6.h),
                CustomPasswordField(
                  label: AppStrings.password,
                  controller: _passwordController,
                  onChanged: (password) => context
                      .read<LoginBloc>()
                      .add(LoginPasswordChanged(password)),
                ),
                const Text(
                  AppStrings.validatePassword,
                  style: TextStyle(
                    color: AppColors.textGrey,
                    fontSize: 12,
                    fontFamily: 'SF Pro Display',
                    fontWeight: FontWeight.w400,
                    height: 0,
                  ),
                ),
                SizedBox(height: 30.h),
                InkWell(
                  onTap: () {
                    context.read<LoginBloc>().add(const LoginSubmitted());
                    // Navigator.push(
                    //     context,
                    //     MaterialPageRoute(builder: (context)=> SignInEmailScreen()),
                    // );

                    // String title = r'半角英大文字小文字と数字の組み合わせに問題があるか使えない文字が入力されました';
                    // String content = r'お客様番号をお確かめの上再度入力してください';
                    // CustomDialog.alertDialog(
                    //     context: context, title: title, content: content);
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
                          AppStrings.login,
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
                SizedBox(height: 10.h),
                const Center(
                  child: Text(
                    AppStrings.forgotPassword,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: Color(0xFF2F80ED),
                      fontSize: 14,
                      fontFamily: 'SF Pro Display',
                      fontWeight: FontWeight.w400,
                      height: 0,
                    ),
                  ),
                ),
              ],
            ),
          );
        },
      ),
    );
  }
}
