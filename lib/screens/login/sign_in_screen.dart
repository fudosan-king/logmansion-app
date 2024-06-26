import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:formz/formz.dart';
import '../../blocs/login/login_bloc.dart';
import '../../blocs/login/login_event.dart';
import '../../blocs/login/login_state.dart';
import '../../repositories/authentication_repository.dart';
import '../../utils/validators.dart';
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
  final _clientIDController = TextEditingController();
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
                emailController: _clientIDController,
                passwordController: _passwordController),
          ],
        ),
      ),
    );
  }
}

class LoginForm extends StatefulWidget {
  LoginForm({
    super.key,
    required TextEditingController emailController,
    required TextEditingController passwordController,
  })  : _emailController = emailController,
        _passwordController = passwordController;

  final TextEditingController _emailController;
  final TextEditingController _passwordController;

  @override
  State<LoginForm> createState() => _LoginFormState();
}

class _LoginFormState extends State<LoginForm> {
  bool hasError = false;

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
          return Column(
            mainAxisSize: MainAxisSize.min,
            mainAxisAlignment: MainAxisAlignment.start,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              SizedBox(height: 30.h),
              if (hasError)
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
                      controller: widget._emailController,
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
                controller: widget._passwordController,
                onChanged: (password) => context
                    .read<LoginBloc>()
                    .add(LoginPasswordChanged(password)),
              ),
              // const Text(
              //   AppStrings.validatePassword,
              //   style: TextStyle(
              //     color: AppColors.textGrey,
              //     fontSize: 12,
              //     fontFamily: 'SF Pro Display',
              //     fontWeight: FontWeight.w400,
              //     height: 0,
              //   ),
              // ),
              SizedBox(height: 50.h),
              InkWell(
                onTap: () {
                  if (widget._emailController.text != "" &&
                      widget._passwordController.text != "") {
                    context.read<LoginBloc>().add(const LoginSubmitted());
                  } else {
                    setState(() {
                      hasError = true;
                    });
                  }
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
              SizedBox(height: 20.h),
              Center(
                child: InkWell(
                  onTap: () {
                    handleForgot(context);
                  },
                  child: const Text(
                    AppStrings.forgotPasswordLabel,
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
              ),
              const Center(
                child: Text(
                  'or',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    color: AppColors.textWhite,
                    fontSize: 14,
                    fontFamily: 'SF Pro Display',
                    fontWeight: FontWeight.w400,
                    height: 0,
                  ),
                ),
              ),
              const Center(
                child: Text(
                  AppStrings.forgotIDLabel,
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
          );
        },
      ),
    );
  }

  void handleForgot(BuildContext context) {
    showGeneralDialog(
      context: context,
      barrierLabel: "",
      barrierDismissible: true,
      barrierColor: Colors.black.withOpacity(0.5),
      transitionDuration: const Duration(milliseconds: 200),
      pageBuilder: (_, __, ___) {
        return Center(
          child: popUp(context),
        );
      },
      // transitionBuilder: (_, anim, __, child) {
      //   Tween<Offset> tween;
      //   if (anim.status == AnimationStatus.reverse) {
      //     tween = Tween(begin: const Offset(0, -1), end: Offset.zero);
      //   } else {
      //     tween = Tween(begin: const Offset(0, -1), end: Offset.zero);
      //   }
      //
      //   return SlideTransition(
      //     position: tween.animate(anim),
      //     child: FadeTransition(
      //       opacity: anim,
      //       child: child,
      //     ),
      //   );
      // },
    );
  }

  Widget popUp(BuildContext context) {
    TextEditingController emailController = TextEditingController();
    String? emailError;
    return Container(
      width: 335.w,
      padding: EdgeInsets.symmetric(horizontal: 20.w, vertical: 12.h),
      clipBehavior: Clip.antiAlias,
      decoration: ShapeDecoration(
        color: Colors.white,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
      ),
      child: ConstrainedBox(
        constraints: BoxConstraints(
          minHeight: 220.h,
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          mainAxisAlignment: MainAxisAlignment.start,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const SizedBox(
              width: double.infinity,
              child: Row(
                mainAxisSize: MainAxisSize.min,
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  Expanded(
                    child: SizedBox(
                      child: Text(
                        AppStrings.forgotPassword,
                        style: const TextStyle(
                          color: Color(0xFFB49554),
                          fontSize: 20,
                          fontFamily: 'SF Pro Display',
                          fontWeight: FontWeight.w700,
                          decoration: TextDecoration.none,
                        ),
                      ),
                    ),
                  ),
                  SizedBox(width: 10),
                  // Container(
                  //   width: 24,
                  //   height: 24,
                  //   padding: const EdgeInsets.all(5),
                  //   child: Icon(Icons.close, color: AppColors.textGrey, size: 24),
                  // ),
                ],
              ),
            ),
            SizedBox(height: 12.h),
            const Text(
              AppStrings.noteForgotID,
              style: TextStyle(
                color: AppColors.textGrey500,
                fontSize: 16,
                fontFamily: 'SF Pro Display',
                fontWeight: FontWeight.w700,
                decoration: TextDecoration.none,
              ),
            ),
            SizedBox(height: 12.h),
            Card(
              child: TextFormField(
                controller: emailController,
                decoration: InputDecoration(labelText: '', errorText: emailError),
                onFieldSubmitted: (value) {
                  setState(() {
                    emailError = Validators.emailValidator(value);
                  });
                },
              ),
            ),
            SizedBox(height: 12.h),
            Row(
              mainAxisAlignment: MainAxisAlignment.end,
              children: [
                Card(
                  child: Container(
                    width: 100.w,
                    height: 40.w,
                    padding: const EdgeInsets.all(10),
                    decoration: ShapeDecoration(
                      color: AppColors.buttonColor,
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
                    ),
                    child: InkWell(
                      onTap: (){
                        if(emailError == null){
                          print(12312321312312);
                          context
                              .read<LoginBloc>()
                              .add(ForgotPassword(emailController.text));
                        }
                        // print(emailController.text);
                      },
                      child: const Center(
                        child: Text(
                          'Send',
                          style: TextStyle(
                            color: AppColors.textWhite,
                            fontSize: 16,
                            fontFamily: 'SF Pro Display',
                            fontWeight: FontWeight.w700,
                            decoration: TextDecoration.none,
                          ),
                        ),
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
